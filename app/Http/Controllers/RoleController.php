<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Employee;
use App\Models\Student;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.view')) {
            abort(403, 'Unauthorized: You do not have permission to view roles.');
        }

        $roles = Role::with('permissions')->get()->map(function ($role) {
            // Count assigned models based on guard
            if ($role->guard_name === 'web') {
                $role->assigned_count = User::role($role->name, 'web')->count();
            } elseif ($role->guard_name === 'employee') {
                $role->assigned_count = Employee::role($role->name, 'employee')->count();
            } elseif ($role->guard_name === 'student') {
                $role->assigned_count = Student::role($role->name, 'student')->count();
            } else {
                $role->assigned_count = 0;
            }
            return $role;
        });

        $totalPermissions = Permission::count();
        $webPermissionsCount = Permission::where('guard_name', 'web')->count();
        $employeePermissionsCount = Permission::where('guard_name', 'employee')->count();
        $studentPermissionsCount = Permission::where('guard_name', 'student')->count();

        return view('roles.index', compact(
            'roles',
            'totalPermissions',
            'webPermissionsCount',
            'employeePermissionsCount',
            'studentPermissionsCount'
        ));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.create')) {
            abort(403, 'Unauthorized: You do not have permission to create roles.');
        }

        $webPermissions = Permission::where('guard_name', 'web')->get()->groupBy('group_name');
        $employeePermissions = Permission::where('guard_name', 'employee')->get()->groupBy('group_name');
        $studentPermissions = Permission::where('guard_name', 'student')->get()->groupBy('group_name');

        return view('roles.create', compact('webPermissions', 'employeePermissions', 'studentPermissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.create')) {
            abort(403, 'Unauthorized: You do not have permission to create roles.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'guard_name' => 'required|string|in:web,employee,student',
            'permissions' => 'nullable|array',
        ]);

        $roleName = strtolower(trim($request->name));

        $exists = Role::where('name', $roleName)
            ->where('guard_name', $request->guard_name)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['name' => 'A role with this name already exists for the selected guard.'])->withInput();
        }

        $role = Role::create([
            'name' => $roleName,
            'guard_name' => $request->guard_name,
        ]);

        if ($request->has('permissions') && is_array($request->permissions)) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('message', 'Role "' . ucfirst($role->name) . '" created successfully with ' . count($request->permissions ?? []) . ' permissions!');
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        return redirect()->route('roles.edit', ['role' => $id]);
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id)
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.edit')) {
            abort(403, 'Unauthorized: You do not have permission to edit roles.');
        }

        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::where('guard_name', $role->guard_name)->get()->groupBy('group_name');
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.edit')) {
            abort(403, 'Unauthorized: You do not have permission to edit roles.');
        }

        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'permissions' => 'nullable|array',
        ]);

        if ($role->name !== 'superadmin') {
            $role->name = strtolower(trim($request->name));
            $role->save();
        }

        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('message', 'Role "' . ucfirst($role->name) . '" updated successfully!');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.delete')) {
            abort(403, 'Unauthorized: You do not have permission to delete roles.');
        }

        $role = Role::findOrFail($id);

        if ($role->name === 'superadmin') {
            return redirect()->back()->with('error', 'Super Admin role cannot be deleted.');
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('roles.index')->with('message', 'Role "' . ucfirst($roleName) . '" deleted successfully.');
    }

    /**
     * Display a full permissions matrix.
     */
    public function matrix()
    {
        if (auth()->check() && !auth()->user()->hasRole('superadmin') && !auth()->user()->can('roles.view')) {
            abort(403, 'Unauthorized: You do not have permission to view permissions matrix.');
        }

        $roles = Role::with('permissions')->get();
        $permissionsByGroup = Permission::all()->groupBy(['guard_name', 'group_name']);

        return view('roles.matrix', compact('roles', 'permissionsByGroup'));
    }
}
