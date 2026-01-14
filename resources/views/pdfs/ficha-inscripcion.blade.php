{{-- resources/views/pdfs/ficha-inscripcion.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ficha de Inscripción - {{ $alumno->user->name ?? '' }}</title>
    
    <style>
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            padding: 20px; 
            font-size: 10px; 
            color: #1f2937;
        }
        .main-container-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .header-cell { padding: 5px 0; border-bottom: 3px solid #6366f1; }
        .header h1 { color: #6366f1; font-size: 18px; margin: 0; text-transform: uppercase; }
        .header-subtitle { color: #1e3a8a; font-size: 11px; margin: 0; }
        .header-info { text-align: right; font-size: 8px; }
        .logo { width: 80px; height: auto; }
        .section-header { background-color: #eef2ff; color: #1f2937; padding: 5px 15px; margin-top: 15px; margin-bottom: 5px; font-size: 11px; font-weight: bold; border-left: 4px solid #6366f1; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .data-table td { padding: 4px 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .data-label { font-weight: bold; width: 20%; color: #374151; }
        .data-field { width: 30%; }
        .program-card { border: 1px solid #a5b4fc; margin-bottom: 10px; padding: 5px; background-color: #eef2ff; border-radius: 4px; }
        .program-title { font-weight: bold; color: #3730a3; margin-bottom: 3px; font-size: 10px; }
        .terms-section { margin-top: 25px; padding: 8px; border: 1px dashed #9ca3af; background-color: #f9fafb; }
        .terms-section h4 { font-size: 11px; color: #6366f1; margin-top: 0; margin-bottom: 3px; }
        .terms-section ul { list-style: disc; padding-left: 15px; margin: 0; font-size: 9px; }
        .signature-container { width: 100%; text-align: right; margin-top: 30px; }
        .signature-line { border-top: 1px solid #000; width: 45%; display: inline-block; padding-top: 5px; text-align: center; font-size: 10px; }
        .photo-box-table { width: 100px; height: 120px; border: 1px solid #d1d5db; text-align: center; vertical-align: middle; font-size: 9px; background-color: #f9fafb; }
    </style>
</head>
<body>

<table class="main-container-table">
    <tr>
        {{-- Logo con conversión a Base64 para evitar errores de GD/Rutas --}}
        <td style="width: 20%; vertical-align: top;">
            @php
                $path = public_path('images/logo.png');
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                } else {
                    $base64 = null;
                }
            @endphp
            @if($base64)
                <img src="{{ $base64 }}" alt="Logo Club" class="logo">
            @else
                <div style="border: 1px solid #ccc; width: 70px; height: 70px; text-align: center; font-size: 8px; padding-top: 20px;">LOGO</div>
            @endif
        </td>

        {{-- Título --}}
        <td style="width: 55%; vertical-align: top; padding-left: 10px;">
            <div class="header">
                <h1>CLUB DE BOX EL TIGRE</h1>
                <p class="header-subtitle">FICHA DE INSCRIPCIÓN - CURSO INDUCTIVO</p>
            </div>
        </td>

        {{-- Foto y fecha --}}
        <td style="width: 25%; text-align: right; vertical-align: top;">
            <table class="photo-box-table" align="right">
                <tr><td>FOTO AQUÍ</td></tr>
            </table>
            <div class="header-info" style="clear: both; padding-top: 5px;">
                 Generado: {{ now()->format('d/m/Y H:i') }}
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 3px solid #6366f1; padding-top: 10px;"></td>
    </tr>
</table>

{{-- 1. DATOS DEL ALUMNO --}}
<div class="section-header">1. DATOS PRINCIPALES DEL ALUMNO</div>
<table class="data-table">
    <tr>
        <td class="data-label">Nombre Completo:</td>
        <td class="data-field">{{ $alumno->user->name ?? '' }}</td>
        <td class="data-label">DNI:</td>
        <td class="data-field">{{ $alumno->dni ?? '' }}</td>
    </tr>
    <tr>
        <td class="data-label">Domicilio:</td>
        <td class="data-field" colspan="3">{{ $alumno->direccion ?? '' }}</td>
    </tr>
    <tr>
        <td class="data-label">N° Celular:</td>
        <td class="data-field">{{ $alumno->telefono ?? '' }}</td>
        <td class="data-label">Fecha Nacimiento / Edad:</td>
        <td class="data-field">
            @if($alumno->fecha_nacimiento)
                {{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->age }} años)
            @endif
        </td>
    </tr>
</table>

{{-- 2. APODERADO --}}
<div class="section-header">2. DATOS DEL APODERADO / CONTACTO DE EMERGENCIA</div>
<table class="data-table">
    <tr>
        <td class="data-label">Nombre Apoderado:</td>
        <td class="data-field">{{ $alumno->apoderado_nombre ?? '' }}</td>
        <td class="data-label">N° Celular:</td>
        <td class="data-field">{{ $alumno->apoderado_celular ?? '' }}</td>
    </tr>
    <tr>
        <td class="data-label">Medio de Contacto:</td>
        <td class="data-field" colspan="3">{{ $alumno->medio_contacto ?? '' }}</td>
    </tr>
</table>

{{-- 3. PROGRAMAS --}}
<div class="section-header">3. PROGRAMAS INSCRITOS Y PLAN DE PAGOS</div>
@forelse($alumno->inscripciones as $inscripcion)
    <div class="program-card">
        <p class="program-title">{{ $inscripcion->categoria->nombre ?? 'Programa Desconocido' }} (ID: #{{ $inscripcion->id ?? '---' }})</p>
        <table class="data-table" style="margin-bottom: 0; border: none;">
            <tr>
                <td class="data-label" style="width: 15%; border: none;">Periodo:</td>
                <td class="data-field" style="width: 35%; border: none;">{{ $inscripcion->periodo->nombre ?? '' }}</td>
                <td class="data-label" style="width: 15%; border: none;">Vigencia:</td>
                <td class="data-field" style="width: 35%; border: none;">
                    {{ $inscripcion->fecha_inicio ? \Carbon\Carbon::parse($inscripcion->fecha_inicio)->format('d/m/Y') : '' }} 
                    a 
                    {{ $inscripcion->fecha_fin ? \Carbon\Carbon::parse($inscripcion->fecha_fin)->format('d/m/Y') : '' }}
                </td>
            </tr>
            <tr>
                <td class="data-label" style="border: none;">Horario:</td>
                <td class="data-field" style="border: none;">{{ $inscripcion->horario->nombre ?? 'No asignado' }}</td>
                <td class="data-label" style="border: none;">Estado:</td>
                <td class="data-field" style="border: none;">{{ ucfirst($inscripcion->estado ?? '') }}</td>
            </tr>
            @if($inscripcion->cuentasInscripcion && $inscripcion->cuentasInscripcion->count())
                @php $cuenta = $inscripcion->cuentasInscripcion->first(); @endphp
                <tr>
                    <td class="data-label" style="border: none;">Monto Total:</td>
                    <td class="data-field" style="border: none;">$ {{ number_format($cuenta->monto_total ?? 0, 2) }}</td>
                    <td class="data-label" style="border: none;">Cuotas Pendientes:</td>
                    <td class="data-field" style="border: none;">{{ $cuenta->cuotas->where('estado', 'pendiente')->count() ?? 0 }}</td>
                </tr>
            @endif
        </table>
    </div>
@empty
    <p style="padding: 10px; color: #dc2626; border: 1px solid #fecaca; background-color: #fef2f2;">El alumno no tiene inscripciones registradas.</p>
@endforelse

{{-- Términos y firma --}}
<div class="terms-section">
    <h4>Términos y Condiciones del Servicio (Extracto)</h4>
    <ul>
        <li>El alumno o apoderado declara haber revisado las normas del club relativas a disciplina, puntualidad y vestimenta.</li>
        <li>El pago de la matrícula y mensualidades debe realizarse antes del día 5 de cada mes para mantener la reserva de cupo y horario.</li>
        <li>En caso de abandono o inasistencia, la mensualidad no será reembolsada ni transferida a otro periodo.</li>
        <li>El club no se hace responsable por la pérdida de objetos personales.</li>
    </ul>
</div>

<div class="signature-container">
    <div class="signature-line">
        Firma del Alumno / Apoderado
    </div>
</div>

</body>
</html>