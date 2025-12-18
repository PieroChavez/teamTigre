@extends('layouts.web')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/informacion.css') }}">
@endsection


@section('content')
<section class="informacion" id="seccion-informacion-tigre">
    <div class="historia">
        <div class="info-container d-flex flex-wrap align-items-center">
            
            <div class="col-md-6 imagen-container">
                <img src="{{ asset('img/historia.jpg') }}" alt="Historia del Club" class="img-fluid">
            </div>
            
            <div class="col-md-6 ps-md-5 mt-4 mt-md-0">
                <h2>Historia del Club</h2>
                <p>Con más de 10 años de experiencia en Huancayo, el Club de Box "El Tigre" se ha dedicado a formar campeones y promover la disciplina deportiva. Nuestro compromiso con la educación, la salud y el bienestar nos ha consolidado como una institución de referencia en la región.</p>
                <a href="{{ route('web.informacion') }}" class="btn btn-success mt-3">Más Información</a>
            </div>
        </div>
    </div>

    <div class="mision">
        <div class="info-container d-flex flex-wrap align-items-center">
            
            <div class="col-md-6 pe-md-5 order-md-2 imagen-container">
                <img src="{{ asset('img/mision.jpg') }}" alt="Misión" class="img-fluid">
            </div>
            
            <div class="col-md-6 mt-4 mt-md-0 order-md-1">
                <h2>Misión</h2>
                <p>Formar atletas íntegros, promoviendo la disciplina, el respeto y la excelencia en cada entrenamiento, brindando un espacio seguro y profesional para el desarrollo personal y deportivo de nuestros alumnos.</p>
            </div>
        </div>
    </div>

    {{-- ************************************************************ --}}
    {{-- VALORES: ACTUALIZADO CON CONTENEDOR DE ICONO --}}
    {{-- ************************************************************ --}}
    <div class="valores">
        <div class="info-container">
            <h2 class="text-center">Nuestros Valores</h2>
            <div class="row">
                
                <div class="col-md-4 mb-4">
                    <div class="card valor-card text-center h-100"> 
                        <div class="icono-container">
                            {{-- AQUÍ VA LA IMAGEN/ICONO DE DISCIPLINA --}}
                            <i class="fas fa-hand-rock"></i>
                        </div>
                        <h3>Disciplina</h3>
                        <p>El entrenamiento constante y la perseverancia nos definen.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card valor-card text-center h-100">
                        <div class="icono-container">
                            {{-- AQUÍ VA LA IMAGEN/ICONO DE RESPETO --}}
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Respeto</h3>
                        <p>Fomentamos el respeto dentro y fuera del ring.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card valor-card text-center h-100">
                        <div class="icono-container">
                            {{-- AQUÍ VA LA IMAGEN/ICONO DE EXCELENCIA --}}
                            <i class="fas fa-medal"></i>
                        </div>
                        <h3>Excelencia</h3>
                        <p>Buscamos siempre la mejora continua y la superación personal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ************************************************************ --}}


    {{-- ************************************************************ --}}
    {{-- LOGROS: ACTUALIZADO CON CONTENEDOR DE ICONO ANTES DEL NÚMERO --}}
    {{-- ************************************************************ --}}
    <div class="logros">
        <div class="info-container">
            <h2 class="text-center">Nuestros Logros</h2>
            <div class="row">
                
                <div class="col-md-4 mb-4">
                    <div class="logro-card h-100"> 
                        <div class="icono-container">
                             {{-- AQUÍ VA LA IMAGEN/ICONO DE CAMPEONATOS --}}
                            <i class="fas fa-trophy"></i>
                        </div>
                        <span class="numero">+50</span>
                        <h3 class="descripcion">Campeonatos Regionales</h3>
                        <p>medallas obtenidas en competencias locales y regionales.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="logro-card h-100">
                        <div class="icono-container">
                            {{-- AQUÍ VA LA IMAGEN/ICONO DE ALUMNOS --}}
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <span class="numero">10+</span>
                        <h3 class="descripcion">Alumnos Destacados</h3>
                        <p>Varios alumnos han llegado a niveles nacionales e internacionales.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="logro-card h-100">
                        <div class="icono-container">
                            {{-- AQUÍ VA LA IMAGEN/ICONO DE COMUNIDAD --}}
                            <i class="fas fa-award"></i>
                        </div>
                        <span class="numero">2024</span>
                        <h3 class="descripcion">Reconocimiento Comunitario</h3>
                        <p>Premios y menciones por el impacto social y deportivo en la comunidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ************************************************************ --}}
</section>
@endsection