<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan; // Asegúrate de importar tu modelo Plan
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Muestra la lista de todos los planes.
     */
    public function index()
    {
        $plans = Plan::orderBy('price', 'asc')->get();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Muestra el formulario para crear un nuevo plan.
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Almacena un nuevo plan en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'active' => 'boolean',
        ]);

        Plan::create($request->all());

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan creado exitosamente.');
    }


    public function edit(Plan $plan)
    {
        // Se inyecta el modelo Plan directamente (Route Model Binding)
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Actualiza el plan en la base de datos.
     */
    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'active' => 'boolean',
        ]);

        $plan->update($request->all());

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan actualizado exitosamente.');
    }
    
    public function destroy(Plan $plan)
    {
        // 1. Eliminar el Plan
        $plan->delete();

        // 2. Redireccionar con un mensaje de éxito
        return redirect()->route('admin.plans.index')
                         ->with('success', 'El plan "' . $plan->name . '" ha sido eliminado exitosamente.');
    }
}