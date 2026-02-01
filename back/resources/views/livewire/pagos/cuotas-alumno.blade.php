<div class="p-4 bg-white shadow rounded">
    <h2 class="text-lg font-bold mb-2">Pagos y Cuotas</h2>

    <select wire:model="selectedAlumno" class="border p-2 rounded mb-4 w-full">
        <option value="">Seleccione un alumno</option>
        @foreach($alumnos as $alumno)
            <option value="{{ $alumno->id }}">{{ $alumno->nombre }} {{ $alumno->apellido }}</option>
        @endforeach
    </select>

    @if($cuotas)
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Monto Total</th>
                    <th>Descuento</th>
                    <th>Monto Final</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cuotas as $cuenta)
                    <tr>
                        <td>{{ $cuenta->conceptoPago->nombre }}</td>
                        <td>{{ $cuenta->monto_total }}</td>
                        <td>{{ $cuenta->descuento }}</td>
                        <td>{{ $cuenta->monto_final }}</td>
                        <td>{{ $cuenta->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
