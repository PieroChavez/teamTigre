<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CoachProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['coaches', 'plans'])->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', 
            'level' => 'required|string|max:100',
            'type' => 'required|string|max:100',
        ]);

        try {
            Category::create([
                'name' => $validatedData['name'],
                'level' => $validatedData['level'],
                'type' => $validatedData['type'],
                'active' => 1,
            ]);
            
            return redirect()->route('admin.categories.index')->with('success', '¡Categoría creada con éxito!');

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Error al crear categoría (FINAL): " . $e->getMessage());
            
            return back()->withInput()->withErrors(['db_error' => 'No se pudo guardar la categoría. Revisa el log de errores.']);
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255|unique:categories,name,' . $category->id,
            'level'         => 'required|string|max:100',
            'type'          => 'required|string|max:100',
            'description'   => 'nullable|string',
            'active'        => 'sometimes|boolean', 
        ]);
        
        DB::beginTransaction();

        try {
            $category->update($validatedData);

            DB::commit();
            return redirect()->route('admin.categories.index')
                ->with('success', 'Categoría actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar categoría: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->plans()->exists() || $category->coaches()->exists()) {
                $category->update(['active' => 0]);
                return redirect()->back()->with('success', 'La categoría tiene registros asociados y ha sido desactivada en lugar de eliminada.');
            }

            $category->delete();
            return redirect()->back()->with('success', 'Categoría eliminada permanentemente.');

        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al intentar eliminar la categoría.');
        }
    }
    
    public function editCoaches(Category $category)
    {
        $category->load('coaches.user');
        $coaches = CoachProfile::with('user')->get();

        return view('admin.categories.coaches', compact('category', 'coaches'));
    }

    public function updateCoaches(Request $request, Category $category)
    {
        $request->validate([
            'coaches'   => 'nullable|array',
            'coaches.*' => 'exists:coach_profiles,id', 
        ]);
        
        try {
            $category->coaches()->sync($request->coaches ?? []);
            
            return redirect()->route('admin.categories.index')
                ->with('success', 'Asignación de coaches actualizada para ' . $category->name);

        } catch (\Exception $e) {
            Log::error('Error sincronizando coaches: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al sincronizar los coaches.');
        }
    }
}