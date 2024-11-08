<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::where('name', '!=', 'Desarrollador')->get();
        // $data = Role::all();
        return view('roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->permisos) {
            foreach ($request->permisos as $value) {
                $role->givePermissionTo($value);
            }
        }

        return redirect()->route('role.index')->with('success', 'El registro se ha creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Role::find($id);
        return view('roles.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Role::find($id);
        return view('roles.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $permissions = $role->getAllPermissions();

        foreach ($permissions as $value) {
            $role->revokePermissionTo($value);
        }

        if ($request->permisos) {
            foreach ($request->permisos as $value) {
                $role->givePermissionTo($value);
            }
        }

        return redirect()->route('role.index')->with('success', 'El registro se ha actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Role::find($id);
        $permissions = $data->getAllPermissions();

        foreach ($permissions as $value) {
            $data->revokePermissionTo($value);
        }
        $data->delete();
        return redirect()->route('role.index')->with('success', 'El registro se ha eliminado exitosamente.');
    }
}
