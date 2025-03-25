<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TeachingUnit;
use Illuminate\Http\Request;

class DepartmentHeadController extends Controller
{

    public function index()
    {
        // Eager load the 'filiere' relationship to avoid N+1 queries
        $units = TeachingUnit::with('filiere')->get();
        $units = TeachingUnit::with('assignments.professor')->get();
        return view('DepartmentHead/TeachingUnits', compact('units'));
    }

    public function find($id){
        $unit = TeachingUnit::with('filiere')->find($id);
        return view('DepartmentHead/unit', compact('unit'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $searchOption = $request->input('option', 'id');

        // Start the query with the TeachingUnit model
        $query = TeachingUnit::query();

        // Apply search condition based on searchOption (status or other options)
        if ($searchOption === 'status') {
            // Query units that have assignments with the specified status
            $status = $searchTerm; // Assuming the search term is the status
            $query->whereHas('assignments', function($q) use ($status) {
                $q->where('status', $status); // Filter by the specified status
            });
        }

        // Apply search condition based on searchTerm for other options
        if ($searchTerm && $searchOption !== 'status') {
            if ($searchOption === 'id') {
                // Search by id, ensure the id is treated as a string for pattern matching
                $query->whereRaw("CAST(id AS CHAR) LIKE ?", ['%' . $searchTerm . '%']);
            } else {
                // Search by other fields (e.g., name or description)
                $query->where($searchOption, 'like', '%' . $searchTerm . '%');
            }
        }

        // Execute the query and paginate the results
        $units = $query->paginate(10)->appends(request()->query());

        // Return the view with the search results
        return view('DepartmentHead/TeachingUnits', compact('units'));
    }

    public function assign(Request $request, $id){
        $unit = TeachingUnit::with('filiere')->findOrFail($id);
        return view('DepartmentHead/assignUnit', compact('unit'));
    }



}
