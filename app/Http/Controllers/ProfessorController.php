<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Professor;
use App\Models\TeachingUnit;
use App\Models\User;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(){
        $professors = User::all()->where('role', 'professor');
        return view('professors.index', compact('professors'));
    }

    public function show($id){
        $professor = User::find($id);
        return view('Professor/profile', compact('professor'));
    }
    public function assign($id){
        $professor = User::find($id);
        $units = TeachingUnit::with('filiere')->get();
//        $prof_department = ;
        return view('DepartmentHead/assignUnits', compact('professor'));
    }


}
