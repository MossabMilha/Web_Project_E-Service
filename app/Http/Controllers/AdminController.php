<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Models\Assignment;
use App\Models\LogModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use function Illuminate\Events\queueable;

class AdminController extends Controller
{
    // Apply middleware to ensure the user is authenticated and is an admin
    public function __construct()
    {
        $this->middleware('auth');  // Ensure the user is authenticated
        $this->middleware('admin'); // Ensure the user is an admin
    }


    public function UserInformation($id)
    {
        $user = User::findOrFail($id);
        LogModel::track('visit_user_information', "Admin (ID: " . Auth::user()->id . ") viewed information for User ID: {$id}");
        return view('AdminUserInfo', compact('user'));
    }

    // Show Add User form
    public function AddUser()
    {
        LogModel::track('visit_add_user_form', "Admin (ID: " . Auth::user()->id . ") visited Add User form");
        return view('AdminAddUser');
    }

    // Search users
    public function search(Request $request)
    {
        LogModel::track('search_users', "Admin (ID: " . Auth::user()->id . ") searched users with term '{$request->input('search')}' and option '{$request->input('option')}'");
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
        LogModel::track('delete_user_attempt', "Admin (ID: " . Auth::user()->id . ") attempted to delete User ID: {$id}");
        $admin = Auth::user();

        if (!Hash::check($request->password, $admin->password)) {
            return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['user' => 'User not found.']);
        }

        $user->delete();
        return redirect()->route('UserManagement.search')->with('success', 'User deleted successfully.');
    }

    // Delete assignment
    public function DeleteAssignment($id)
    {
        LogModel::track('delete_assignment', "Admin (ID: " . Auth::user()->id . ") deleted Assignment ID: {$id}");

        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }

    // Add assignment


    // Add user to the database
    public function AddUserDb(Request $request)
    {
        LogModel::track('add_user', "Admin (ID: " . Auth::user()->id . ") added a new user with email: {$request->email}");
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
        LogModel::track('edit_user', "Admin (ID: " . Auth::user()->id . ") edited User ID: {$id}");

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

    public function sort(Request $request)
    {
        LogModel::track('sort_logs', "Admin (ID: " . Auth::user()->id . ") sorted logs by '{$request->get('sort_by')}' in '{$request->get('sort_order')}' order with role '{$request->get('role')}'");
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $role = $request->get('role');

        $allowedSorts = ['id', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $logsQuery = LogModel::with('user')
            ->when($role, function ($query) use ($role) {
                $query->whereHas('user', function ($q) use ($role) {
                    $q->where('role', $role);
                });
            })
            ->orderBy($sortBy, $sortOrder);

        $logs = $logsQuery->paginate(10)->appends(request()->query());

        return view('AdminLogs', compact('logs'));
    }
    public function export(Request $request)
    {
        LogModel::track('export_logs', "Admin (ID: " . Auth::user()->id . ") exported logs as Excel");
        return Excel::download(new LogsExport($request), 'logs.xlsx');
    }
}
