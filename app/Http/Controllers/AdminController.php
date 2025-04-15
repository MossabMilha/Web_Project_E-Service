<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\LogModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use function Illuminate\Events\queueable;

class AdminController extends Controller
{
    // Apply middleware to ensure the user is authenticated and is an admin
    public function __construct()
    {
        $this->middleware('auth');  // Ensure the user is authenticated
        $this->middleware('admin'); // Ensure the user is an admin
    }

    // View user information
    public function UserInformation($id)
    {
        $user = User::findOrFail($id);
        return view('AdminUserInfo', compact('user'));
    }

    // Show Add User form
    public function AddUser()
    {
        return view('AdminAddUser');
    }

    // Search users
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $searchOption = $request->input('option', 'id');

        // Map frontend search options to database columns
        $columnMap = [
            'id' => 'id',
            'full name' => 'name',
            'email' => 'email',
            'role' => 'role',
            'specialization' => 'specialization',
        ];

        $searchOption = $columnMap[$searchOption] ?? 'id';

        $query = User::query();

        if ($searchTerm) {
            if ($searchOption === 'id') {
                $query->whereRaw("CAST(id AS CHAR) LIKE ?", ['%' . $searchTerm . '%']);
            } else {
                $query->where($searchOption, 'like', '%' . $searchTerm . '%');
            }
        }

        $users = $query->paginate(10)->appends(request()->query());
        return view('AdminUserManagement', compact('users'));
    }

    // Delete user
    public function DeleteUser(Request $request, $id)
    {
        $admin = Auth::user();

        if (!Hash::check($request->password, $admin->password)) {
            return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['user' => 'User not found.']);
        }

        $user->delete();
        return redirect()->route('UserManagement.index')->with('success', 'User deleted successfully.');
    }

    // Delete assignment
    public function DeleteAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }

    // Add assignment


    // Add user to the database
    public function AddUserDb(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'role' => 'required|string|in:admin,department_head,coordinator,professor,vacataire',
            'specialization' => 'nullable|string',
        ]);

        $user = new User($validatedData);
        $user->password = Hash::make('test'); // Default password (should be changed later)
        $user->save();

        return redirect()->route('UserManagement.adduserDB')->with('success', 'User added successfully.');
    }

    // Edit user
    public function EditUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'specialization' => 'nullable|string',
            'role' => 'required|string|in:admin,department_head,coordinator,professor,vacataire',
        ]);

        $user->update($validatedData);

        return redirect()->route('UserManagement.user', $id)->with('success', 'User updated successfully.');
    }

   //logs
    public function logs(){
        $logs = LogModel::with('user')->get();
        return view('AdminLogs',compact('logs'));
    }
}
