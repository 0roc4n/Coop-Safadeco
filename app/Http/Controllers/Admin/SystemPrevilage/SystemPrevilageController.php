<?php

namespace App\Http\Controllers\Admin\SystemPrevilage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class SystemPrevilageController extends Controller
{
    public function index()
    {
        $roles = Role::select('id', 'name', 'created_at')
                     ->with('privileges')
                     ->get();
        
        return Inertia::render('Admin/SystemPrevilage/Index', [
            'roles' => $roles
        ]);
    }
    
    public function update(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'can_read' => 'boolean|nullable',
            'can_add' => 'boolean|nullable',
            'can_update' => 'boolean|nullable',
            'can_delete' => 'boolean|nullable',
        ]);
        
        // Prevent updating Admin role (ID 1) for security
        if ($validated['role_id'] == 1) {
            return back()->with('error', 'Admin privileges cannot be modified');
        }
        
        // Find the privilege by role_id
        $privilege = Privilege::where('role_id', $validated['role_id'])->first();
        
        if (!$privilege) {
            // Create new privilege if it doesn't exist
            $privilege = new Privilege();
            $privilege->role_id = $validated['role_id'];
        }
        
        // Update only the fields that are present in the request
        if (isset($validated['can_read'])) {
            $privilege->can_read = $validated['can_read'];
        }
        
        if (isset($validated['can_add'])) {
            $privilege->can_add = $validated['can_add'];
        }
        
        if (isset($validated['can_update'])) {
            $privilege->can_update = $validated['can_update'];
        }
        
        if (isset($validated['can_delete'])) {
            $privilege->can_delete = $validated['can_delete'];
        }
        
        $privilege->save();
        
        return back()->with('success', 'Privileges updated successfully');
    }
    
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'can_read' => 'boolean',
            'can_add' => 'boolean',
            'can_update' => 'boolean',
            'can_delete' => 'boolean',
        ]);
        
        try {
            // Begin transaction to ensure both role and privilege are created
            DB::beginTransaction();
            
            // Create the role
            $role = new Role();
            $role->name = $validated['name'];
            $role->save();
            
            // Create associated privilege
            $privilege = new Privilege();
            $privilege->role_id = $role->id;
            $privilege->can_read = $validated['can_read'] ?? 0;
            $privilege->can_add = $validated['can_add'] ?? 0;
            $privilege->can_update = $validated['can_update'] ?? 0;
            $privilege->can_delete = $validated['can_delete'] ?? 0;
            $privilege->save();
            
            DB::commit();
            
            return back()->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create role: ' . $e->getMessage()]);
        }
    }
}
