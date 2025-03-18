<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class  AdminController extends Controller
{
    public function UserManagement(){
        $users = User::all();
        return view('AdminUserManagement',compact('users'));
    }
    public function UserInformation($id){
        $user = User::findOrFail($id);
        return view('AdminUserInfo', compact('user'));
    }
    public function AddUser(){
        return view('AdminAddUser');
    }
    public function search(Request $request) {
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

        $users = $query->paginate(10)->appends(request()->query());;

        return view('AdminUserManagement', compact('users'));
    }
    public function DeleteAssignment($id){
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        return redirect()->back()->with('success', 'Assignment has been deleted');

    }
    public function AddAssignment(Request $request){
        // Validate the incoming request data
        $validatedData = $request->validate([

            'unit_id' => 'required|exists:teaching_units,id', // Teaching unit must exist
        ]);

        $professor_id = $request->professor_id;

        $assignment = new Assignment();
        $assignment->professor_id = $professor_id;
        $assignment->unit_id = $validatedData['unit_id'];
        $assignment->status = 'pending';
        $assignment->created_at = now();
        $assignment->updated_at = now();
        $assignment->save();


        return redirect()->back()->with('success', 'Assignment added successfully!');
    }
    public function AddUserDb(Request $request)
    {
        // Validate the request data
        $request->validate([
            'fname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'specialization' => 'nullable|string', // Specialization can be empty for some roles

        ]);
        $password = Str::random(10) . rand(0, 9) . '!@#$%^&*()'[rand(0, 9)];

        // Create a new user
        $user = new User();
        $user->name = $request->input('fname');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->specialization = $request->input('specialization');
        $user->password = Hash::make('test');

        // Save the new user
        $user->save();

        // Redirect back or to another page with success message
        return redirect()->route('UserManagement.adduserDB')->with('success', 'User added successfully!');
    }
    public function EditUser(Request $request, $id){
        $user = User::findOrFail($id);

        // Validate the data from the form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'specialization' => 'nullable|string',
            'role' => 'required|string',
        ]);

        // Update fields if different
        if ($request->input('name') != $user->name) {
            User::updateField($id, 'name', $request->input('name'));
        }

        if ($request->input('email') != $user->email && User::validEmail($request->input('email')) && !User::EmailIsUsed($request->input('email'))) {
            User::updateField($id, 'email', $request->input('email'));
        }

        if ($request->input('specialization') != $user->specialization) {
            User::updateField($id, 'specialization', $request->input('specialization'));
        }

        if ($request->input('role') != $user->role) {
            User::updateField($id, 'role', $request->input('role'));
        }

        return redirect()->route('UserManagement.user', $id)->with('success', 'User updated successfully.');
    }

}
