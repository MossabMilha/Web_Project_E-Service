<?php

namespace App\Http\Controllers;

use App\Exports\LogsExport;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\Filiere;
use App\Models\LogModel;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use function Illuminate\Events\queueable;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');  // Ensure the user is authenticated
        $this->middleware('admin'); // Ensure the user is an admin
    }


    public function UserInformation($id)
    {
        $user = User::with('specialization')->findOrFail($id);
        $userspecialization = Specialization::find($user->specialization);
        $user->specialization_obj = $userspecialization;
        $specializations = Specialization::all();
        LogModel::track('visit_user_information', "Admin (ID: " . Auth::user()->id . ") viewed information for User ID: {$id}");
        return view('AdminUserInfo', compact('user','specializations'));
    }


    public function AddUser()
    {
        LogModel::track('visit_add_user_form', "Admin (ID: " . Auth::user()->id . ") visited Add User form");
        $specializations = Specialization::with('department')->get();

        foreach ($specializations as $specialization) {
            if ($specialization->department) {
                $specialization->department->load('filieres');
            }
        }
        return view('AdminAddUser',compact('specializations'));
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

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
            'role' => 'required|string|in:admin,department_head,coordinator,professor,vacataire',
            'specialization' => $request->role != 'admin' ? 'nullable|exists:specializations,id' : 'nullable',
            'filiere' => 'nullable',
        ]);

        if($request->role == 'admin'){
            $password = User::generateSecurePassword();
            $user = new User([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'role' => $validatedData['role'],
                'specialization' => null,
                'password' => Hash::make($password), // Step 3: Hash the password
            ]);

        }elseif ($request->role == 'department_head') {
            $specialization = Specialization::find($request->specialization);
            if ($specialization && $specialization->department_id) {

                $department = Department::where('id', $specialization->department_id)->first();

                if ($department && $department->head_id !== null) {
                    return redirect()->back()->withErrors(['specialization' => 'This department already has a department head.',]);
                }else{
                    $password = User::generateSecurePassword();
                    $user = new User([
                        'name' => $validatedData['name'],
                        'email' => $validatedData['email'],
                        'phone' => $validatedData['phone'],
                        'role' => $validatedData['role'],
                        'specialization' => $request->specialization,
                        'password' => Hash::make($password)
                    ]);
                    dd($user);
                    $user->save();


                    $department->head_id = $user->id;
                    $department->save();

                }
            }
        }elseif ($request->role == 'coordinator') {
            $specialization = Specialization::find($request->specialization);
            $filliere = $request->filiere;
            if ($specialization && $specialization->department_id) {
                $matchingFilières = Filiere::where('name', 'like', $filliere . '%')
                    ->where('department_id', $specialization->department_id)
                    ->get();
                $hasCoordinator = $matchingFilières->contains(function ($f) {
                    return !is_null($f->coordinator_id);
                });
                if ($hasCoordinator) {
                    return redirect()->back()->withErrors(['filiere' => 'This filiere already has a coordinator.']);
                }
                $password = User::generateSecurePassword();

                $user = new User([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'phone' => $validatedData['phone'],
                    'role' => $validatedData['role'],
                    'specialization' => $request->specialization,
                    'password' => Hash::make($password),
                ]);

                $user->save();
                foreach ($matchingFilières as $filiere) {
                    $filiere->coordinator_id = $user->id;
                    $filiere->save();
                }
            }
        }elseif($request->role == 'vacataire' || $request->role == 'professor') {
            $specialization = Specialization::find($request->specialization);

            if (!$specialization || !$specialization->department_id) {
                return redirect()->back()->withErrors(['specialization' => 'Invalid specialization or missing department.']);
            }

            $password = User::generateSecurePassword();

            $user = new User([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'role' => $request->role,
                'specialization' => $request->specialization,
                'password' => Hash::make($password),
            ]);

            $user->save();

            DepartmentMember::create([
                'professor_id' => $user->id,
                'department_id' => $specialization->department_id,
            ]);

        }
        LogModel::track('add_user', "Admin (ID: " . Auth::user()->id . ") added a new user with email: {$request->email}");
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

        // Custom validation checks
        $errors = [];

        if (($result = User::validName($validatedData['name'])) !== true) {
            $errors['name'] = $result;
        }

        if (($result = User::validEmail($validatedData['email'], $id)) !== true) {
            $errors = array_merge($errors, $result);
        }

        if (($result = User::validPhoneNumber($validatedData['phone'], $id)) !== true) {
            $errors = array_merge($errors, $result);
        }


        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        // Only update the fields that have changed
        foreach ($validatedData as $field => $value) {
            if ($user->$field !== $value) {

                User::updateField($id, $field, $value);
            }
        }

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
