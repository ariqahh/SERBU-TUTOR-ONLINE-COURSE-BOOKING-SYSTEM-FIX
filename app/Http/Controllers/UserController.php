<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return view('apps.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apps.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,mentor,mentee',
            ]);

            // create user
            $user = User::make($request->all());
            $user->password = Hash::make($request->password);
            $user->saveOrFail();

            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // log error
            Log::error('Error creating user: ' . $e->getMessage());

            return redirect()->route('users.index')->with('error', 'User creation failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('apps.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('apps.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            // validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|in:admin,mentor,mentee',
            ]);

            // update user
            $user->fill($request->all());
            $user->saveOrFail();

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            // log error
            Log::error('Error updating user: ' . $e->getMessage());

            return redirect()->route('users.index')->with('error', 'User update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // delete user
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            // log error
            Log::error('Error deleting user: ' . $e->getMessage());

            return redirect()->route('users.index')->with('error', 'User deletion failed');
        }
    }

    /**
     * Display the profile of the user.
     */
    public function profile()
    {
        $user = Auth::user();

        return view('apps.users.profile', compact('user'));
    }

    /**
     * Update the profile of the authenticated user.
     */
    public function updateProfile(Request $request)
    {
        try {
            // Get authenticated user
            $user = Auth::user();

            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            // Check if email is changed
            $emailChanged = $user->email !== $validated['email'];

            // Prepare update data
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            // Reset email verification if email is changed
            if ($emailChanged) {
                $updateData['email_verified_at'] = null;
            }

            // Update user in database
            $updated = User::where('id', $user->id)->update($updateData);

            if (!$updated) {
                throw new \Exception('Failed to update user data');
            }

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error updating profile: ' . $e->getMessage());

            return redirect()->route('profile')->with('error', 'Gagal memperbarui profil');
        }
    }
}
