@extends('layouts.admin') {{-- O la plantilla que uses para el panel de control --}}

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">
                <i class="fas fa-users-cog me-2"></i> Gestión de Usuarios
            </h1>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listado de Usuarios Registrados</h6>
            {{-- Botón para ir a la vista de creación de nuevos usuarios --}}
            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-user-plus"></i>
                </span>
                <span class="text">Añadir Usuario</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- La tabla mostrará los datos de los usuarios --}}
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Registro</th>
                            <th style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 🛑 Bucle para mostrar los usuarios 🛑 --}}
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{-- Lógica simple para mostrar el rol de forma amigable --}}
                                @if ($user->role == 'admin')
                                    <span class="badge bg-danger text-white">Administrador</span>
                                @elseif ($user->role == 'editor')
                                    <span class="badge bg-warning text-dark">Staff/Editor</span>
                                @else
                                    <span class="badge bg-primary text-white">Alumno</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                {{-- Botón Editar --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Botón Eliminar (Formulario) --}}
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" 
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar al usuario {{ $user->name }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay usuarios registrados en el sistema.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Enlaces de paginación --}}
            @if(isset($users) && $users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection