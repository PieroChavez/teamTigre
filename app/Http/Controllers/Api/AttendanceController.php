<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Procesa el escaneo de DNI (Entrada/Salida)
     */
    public function scan(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'string', 'min:6', 'max:30'],
        ]);

        // Limpieza de datos del scanner
        $dni = trim((string) $request->input('dni'));
        $dni = preg_replace('/\s+/', '', $dni); 

        $scanner = $request->user(); // El admin o controlador que escanea

        $person = User::query()
            ->select(['id', 'name', 'email', 'dni'])
            ->where('dni', $dni)
            ->first();

        if (!$person) {
            return response()->json([
                'success' => false,
                'message' => 'DNI no registrado en el sistema.',
            ], 404);
        }

        $today = now()->toDateString();
        $nowTime = now()->format('H:i:s');

        // Transacción con bloqueo de fila para evitar colisiones
        $result = DB::transaction(function () use ($person, $today, $nowTime, $scanner) {
            $attendance = Attendance::query()
                ->where('user_id', $person->id)
                ->where('date', $today)
                ->lockForUpdate()
                ->first();

            // 1. Si no existe registro hoy: Marcamos ENTRADA
            if (!$attendance) {
                $attendance = Attendance::create([
                    'user_id' => $person->id,
                    'date' => $today,
                    'check_in_time' => $nowTime,
                    'marked_by' => $scanner?->id,
                    'source' => 'barcode',
                ]);

                return ['action' => 'check_in', 'attendance' => $attendance];
            }

            // 2. Si existe pero check_in está vacío (corrección manual)
            if (is_null($attendance->check_in_time)) {
                $attendance->update([
                    'check_in_time' => $nowTime,
                    'marked_by' => $scanner?->id,
                ]);
                return ['action' => 'check_in', 'attendance' => $attendance];
            }

            // 3. Si tiene entrada pero NO salida: Marcamos SALIDA
            if (is_null($attendance->check_out_time)) {
                $attendance->update([
                    'check_out_time' => $nowTime,
                    'marked_by' => $scanner?->id,
                ]);
                return ['action' => 'check_out', 'attendance' => $attendance];
            }

            // 4. Ya tiene ambos registros
            return ['action' => 'already_done', 'attendance' => $attendance];
        });

        return response()->json([
            'success' => true,
            'message' => match ($result['action']) {
                'check_in'  => 'Entrada registrada correctamente.',
                'check_out' => 'Salida registrada correctamente.',
                default     => 'El estudiante ya completó su asistencia hoy.',
            },
            'action' => $result['action'],
            'user' => $person,
            'attendance' => $result['attendance'],
        ]);
    }

    /**
     * Lista las asistencias del día actual (con búsqueda)
     */
    public function today(Request $request)
    {
        $today = now()->toDateString();
        $search = trim((string) $request->query('search', ''));

        $q = Attendance::query()
            ->with(['user:id,name,email,dni'])
            ->where('date', $today)
            ->orderByDesc('updated_at');

        if ($search !== '') {
            $q->whereHas('user', function ($u) use ($search) {
                $u->where('dni', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Asistencias de hoy',
            'data' => $q->paginate(30),
        ]);
    }

    /**
     * Historial de asistencias con filtros de fecha y búsqueda
     */
    public function history(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $from = $request->query('from'); // YYYY-MM-DD
        $to   = $request->query('to');   // YYYY-MM-DD

        $q = Attendance::query()
            ->with(['user:id,name,email,dni'])
            ->orderByDesc('date')
            ->orderByDesc('updated_at');

        if ($from) $q->where('date', '>=', $from);
        if ($to)   $q->where('date', '<=', $to);

        if ($search !== '') {
            $q->whereHas('user', function ($u) use ($search) {
                $u->where('dni', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Historial de asistencias cargado.',
            'data' => $q->paginate(30),
        ]);
    }
}