<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{

    public function index()
    {
        return view('admin.permissions', ['permissions' => Permission::all()]);
    }

    public function store(Request $request)
    {
        Permission::create([
            'name' => $request->permission,
        ]);
        return redirect()->back()->with(['success_message' => 'Permission successfully created.']);
    }


    public function edit($id)
    {
        return view('admin.permissions.edit_permission', [
            'permission' => Permission::findOrFail($id),
        ]);
    }


    public function update(Permission $permission)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission)],
        ]);

        $permission->update($inputs);
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json([
            'message' => 'Permission deleted successfully!'
        ]);
    }

    public function remove($id)
    {
        Permission::where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Permission removed successfully!'
        ]);
    }

    public function restore(Permission $permission, $id)
    {
        $permission->whereId($id)->restore();

        return response()->json([
            'message' => 'Permission restored successfully!'
        ]);
    }
}
