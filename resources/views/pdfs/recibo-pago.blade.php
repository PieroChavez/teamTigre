<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Nota de Venta #{{ $pago->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; padding: 10px; width: 80mm; margin: 0 auto; }
        .recibo-container { border: 1px solid #000; padding: 10px; }
        .header { text-align: center; border-bottom: 1px dashed #999; padding-bottom: 5px; margin-bottom: 10px; }
        .header h1 { font-size: 14px; margin: 0; color: #1e3a8a; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .data-table td { padding: 3px 0; }
        .label { font-weight: bold; width: 45%; color: #555; }
        .monto { font-size: 16px; font-weight: bold; text-align: center; padding: 10px 0; border: 1px solid #ccc; background-color: #f3f4f6; margin: 10px 0; }
        .footer { text-align: center; margin-top: 20px; border-top: 1px dashed #999; padding-top: 5px; }
        .highlight { color: #1e3a8a; font-weight: bold; }
    </style>
</head>
<body>
<div class="recibo-container">

    <div class="header">
        <h1>CLUB DE BOX EL TIGRE</h1>
        <p style="margin:2px 0;"><strong>NOTA DE VENTA</strong></p>
        <p style="margin:2px 0;">
            Fecha: {{ $pago->fecha_pago?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}
        </p>
    </div>

    @php
        $inscripcion = $pago->cuotaPago->cuentaInscripcion->inscripcion ?? null;
    @endphp

    <table class="data-table">
        <tr>
            <td class="label">Nota de Venta N°:</td>
            <td>NV-{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</td>
        </tr>

        <tr>
            <td class="label">Alumno:</td>
            <td>{{ $pago->cuotaPago->cuentaInscripcion->inscripcion->alumno->user->name ?? 'No registrado' }}</td>
        </tr>

        <tr>
            <td class="label">Concepto:</td>
            <td>{{ $pago->cuotaPago->concepto ?? '---' }}</td>
        </tr>

        {{-- SECCIÓN DE FECHAS SEPARADAS --}}
        @if($inscripcion)
        <tr>
            <td class="label">Fecha Inicio:</td>
            <td class="highlight">
                {{ $inscripcion->fecha_inicio ? \Carbon\Carbon::parse($inscripcion->fecha_inicio)->format('d/m/Y') : '---' }}
            </td>
        </tr>
        <tr>
            <td class="label">Fecha Fin:</td>
            <td class="highlight">
                {{ $inscripcion->fecha_fin ? \Carbon\Carbon::parse($inscripcion->fecha_fin)->format('d/m/Y') : '---' }}
            </td>
        </tr>
        @endif
    </table>

    <p class="monto">
        MONTO PAGADO: S/ {{ number_format($pago->monto ?? 0, 2) }}
    </p>

    <table class="data-table">
        <tr>
            <td class="label">Método de Pago:</td>
            <td>{{ $pago->tipoPago->nombre ?? 'Efectivo' }}</td>
        </tr>

        <tr>
            <td class="label">Registrado por:</td>
            <td>{{ $pago->usuario->name ?? 'Sistema' }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Gracias por su preferencia 💪</p>
        <p style="font-size: 8px;">ID Inscripción: #{{ $inscripcion->id ?? '---' }}</p>
    </div>

</div>
</body>
</html>