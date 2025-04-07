<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class  AdminController extends Controller
{

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
    public function DeleteUser(Request $request, $id)
    {

        $admin = Auth::user();

        // Validate password input
        if (!Hash::check($request->password, $admin->password)) {
            return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
        }

        // Find the user to delete
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['user' => 'User not found.']);
        }

        $user->delete();
        return redirect()->route('UserManagement.index')->with('success', 'User deleted successfully.');
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'role' => 'required|string',
            'specialization' => 'nullable|string',
        ]);

        $valid = true;
        $errors = [];


        $validNameResult = User::validName($request->input('name'));
        if ($validNameResult !== true) {
            $errors['name'] = $validNameResult;
            $valid = false;
        }


        $validEmailResult = User::validEmail($request->input('email'));
        if ($validEmailResult !== true) {
            $errors['email'] = $validEmailResult;
            $valid = false;
        }


        $validPhoneResult = User::validPhoneNumber($request->input('phone'));
        if ($validPhoneResult !== true) {
            $errors['phone'] = $validPhoneResult;
            $valid = false;
        }

        if (!$valid) {
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        if($user->role == 'professor' || $user->role == 'vacataire' ){
            $user->specialization = $request->input('specialization');
        }else{
            $user->specialization = null;
        }
        $user->password = Hash::make('test');

        $user->save();

        return redirect()->route('UserManagement.adduserDB')->with('success', 'User added successfully!');
    }

    public function EditUser(Request $request, $id){
        $user = User::findOrFail($id);

        // Validate the data from the form
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'specialization' => 'nullable|string',
            'role' => 'required|string',
        ]);
        $errors = [];

        // Update fields if different
        $nameValidation = User::validName($request->input('name'));
        if ($request->input('name') != $user->name) {
            if ($nameValidation === true) {
                User::updateField($id, 'name', $request->input('name'));
            } else {
                $errors['name'] = $nameValidation;
            }
        }

        $phoneValidation = User::validPhoneNumber($request->input('phone'), $id);
        if ($request->input('phone') != $user->phone) {
            if ($phoneValidation === true) {
                User::updateField($id, 'phone', $request->input('phone'));
            } else {
                $errors['phone'] = $phoneValidation;
            }
        }

        $emailValidation = User::validEmail($request->input('email'), $id);
        if ($request->input('email') != $user->email) {
            if ($emailValidation === true) {
                User::updateField($id, 'email', $request->input('email'));
            } else {
                $errors['email'] = $emailValidation;
            }
        }

        if ($request->input('specialization') != $user->specialization) {
            User::updateField($id, 'specialization', $request->input('specialization'));
        }

        if ($request->input('role') != $user->role) {
            User::updateField($id, 'role', $request->input('role'));
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        return redirect()->route('UserManagement.user', $id)->with('success', 'User updated successfully.');
    }

}
