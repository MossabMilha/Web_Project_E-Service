<?php

namespace App\Http\Controllers;

use App\Models\StudentParent;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    // Display all records
    public function index()
    {
        return StudentParent::all();
    }

    // Show a single record
    public function show($id)
    {
        return StudentParent::findOrFail($id);
    }

    // Store a new record
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'parent_id' => 'required|integer',
        ]);

        return StudentParent::create($request->all());
    }

    // Update an existing record
    public function update(Request $request, $id)
    {
        $studentParent = StudentParent::findOrFail($id);
        $studentParent->update($request->all());

        return $studentParent;
    }

    // Delete a record
    public function destroy($id)
    {
        return StudentParent::destroy($id);
    }
}
