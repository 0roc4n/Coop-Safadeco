<?php

namespace App\Http\Controllers\Admin\SystemAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Models\Role;

class SystemAccountsController extends Controller
{
    public function index(){
        // Get all roles except 'member'
        $systemAccounts = User::select('id', 'name', 'email', 'role_id', 'created_at', 'profile_photo_path')
                                ->with('role')
                                ->get();
        $systemRoles = Role::select('id', 'name')
                                ->where('name', '!=', 'member')
                                ->get();
        return Inertia::render('Admin/SystemAccount/Index',[
            'systemAccounts' => $systemAccounts,
            'systemRoles' => $systemRoles
        ]);
    }
    public function create(Request $request){
        Log::info('Profile Photo Upload Request', [
            'has_file' => $request->hasFile('profile_photo_path'),
            'all_files' => $request->allFiles(),
            'all_data' => $request->all()
        ]);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            $filename = uniqid('profile_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile-photos', $filename);
            $profilePhotoPath = 'profile-photos/' . $filename;
        }

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role_id' => $validated['role_id'],
                'profile_photo_path' => $profilePhotoPath,
            ]);
            
            // If using Jetstream's HasProfilePhoto trait
            if ($request->hasFile('profile_photo_path')) {
                $user->updateProfilePhoto($request->file('profile_photo_path'));
            }
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to create system account.']);
        }

        return redirect()->route('admin.system-account.index');
    }
}
