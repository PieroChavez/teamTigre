<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesando pago...</title>
</head>
<body>

<script>
    // Abrir recibo en OTRA pestaña
    window.open("{{ route('pagos.imprimir_recibo', $pagoId) }}", "_blank");

    // Volver al alumno
    window.location.href = "{{ route('alumnos.show', $alumnoId) }}";
</script>

</body>
</html>
