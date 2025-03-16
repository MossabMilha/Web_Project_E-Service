<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;

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
        return redirect()->back()->with('succes', 'Assignment has been deleted');

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

}
