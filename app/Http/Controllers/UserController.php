<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
    return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    // Validate the request, including unique email
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // <-- checks if email exists
        'password' => 'required|confirmed|min:6',
        'usertype' => 'required|in:admin,cashier',
    ]);

    // Create the user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'usertype' => $request->usertype,
    ]);

    // Redirect with success message
    return redirect()->route('users.index')
                     ->with('success', 'User "' . $request->name . '" has been created successfully.');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    // Fetch the user from the database
    $user = User::findOrFail($id);

    // Pass it to the view
    return view('users.edit', compact('user'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, User $user)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:6',
        'usertype' => 'required|in:admin,cashier',
    ]);

    // Update user fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->usertype = $request->usertype;

    // Update password only if provided
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Redirect back to users index with success message
    return redirect()->route('users.index')
                     ->with('success', 'User "' . $user->name . '" has been updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
   
    
       public function destroy(User $user)
{
    // Optional: Prevent deleting yourself
    if (auth()->id() === $user->id) {
        return redirect()->route('users.index')
                         ->with('error', 'You cannot delete your own account.');
    }

    $user->delete();

    return redirect()->route('users.index')
                     ->with('success', 'User deleted successfully.');

    }
}
