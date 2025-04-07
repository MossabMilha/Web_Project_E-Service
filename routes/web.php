<?php


use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\LoginProcesse;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\TeachingStaffController;
use App\Http\Controllers\TeachingUnitController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginProcesse::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginProcesse::class, 'login'])->name('login');


Route::middleware('admin')->group(function () {
    Route::get('/Admin/UserManagement', [AdminController::class, 'search'])->name('UserManagement.search');
    Route::get('/Admin/UserManagement/user/{id}', [AdminController::class, 'UserInformation'])->name('UserManagement.user');
    Route::put('/Admin/UserManagement/user/{id}/edit', [AdminController::class, 'EditUser'])->name('UserManagement.editUser');
    Route::get('/Admin/UserManagement/AddUser', [AdminController::class, 'AddUser'])->name('UserManagement.adduser');
    Route::post('/Admin/UserManagement/AddUser', [AdminController::class, 'AddUserDb'])->name('UserManagement.adduserDB');
    Route::delete('/Admin/UserManagement/DeleteUser/{id}', [AdminController::class, 'DeleteUser'])->name('UserManagement.deleteUser');
    Route::delete('/Admin/UserManagement/assignment/{id}', [AdminController::class, 'DeleteAssignment'])->name('UserManagement.deleteAssignment');
    Route::post('/Admin/UserManagement/assignment', [AdminController::class, 'AddAssignment'])->name('UserManagement.addAssignment');
});


// Group all routes under '/department-head/'
Route::prefix('department-head')
    ->name('department-head.')
//    ->middleware(['auth', 'role:department_head'])
    ->group(function () {
    // ----------------------- Teaching units Routes -----------------------

        // not implemented
        // Show the list of all teaching units that belongs to the same department of department head (the id here is not implemented yet!)
    // Route::get('/teaching-units', [TeachingUnitController::class, 'index'])->name('teaching-units.index');

        // not implemented
    // Route::get('/teaching-units/search', [TeachingUnitController::class, 'search'])->name('teaching-units.search');

    // ----------------------- Professors Routes -----------------------

        // Show the list of all professors that belongs to the same department of department head (needs id to be passed)
    Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');

        // not implemented
    // Route::get('/professors/{id}', [ProfessorController::class, 'show'])->name('professors.show');

        // Show the form to assign a professor to a teaching unit or more
    Route::get('/professors/{id}/assign', [ProfessorController::class, 'assign'])->name('professors.assign');

        // Store the assignment of a professor to a teaching unit or more
    Route::post('/professors/{id}/assign', [ProfessorController::class, 'storeAssignment'])->name('professors.units.store');

        // Remove the assignment of a professor from a teaching unit
    Route::delete('/professors/{professor_id}/units/{unit_id}', [ProfessorController::class, 'destroyAssignment'])->name('professors.units.destroy');
});

Route::middleware(['coordinator'])->group(function () {
    Route::get('/Coordinator/teachingUnits', [CoordinatorController::class, 'teachingUnits'])->name('Coordinator.teachingUnits');
    Route::post('/Coordinator/teachingUnits/AddUnit', [CoordinatorController::class, 'AddUnit'])->name('Coordinator.AddUnit');
    Route::post('/Coordinator/teachingUnits/EditUnit', [CoordinatorController::class, 'EdtUnit'])->name('Coordinator.EditUnit');
    Route::get('/Coordinator/VacataireAccount', [CoordinatorController::class, 'VacataireAccount'])->name('VacataireAccount');
    Route::get('/Coordinator/VacataireAccount/vacataire/{id}', [CoordinatorController::class, 'VacataireInformation'])->name('VacataireAccount.user');
    Route::get('/Coordinator/AddVacataire', [CoordinatorController::class, 'AddVacataire'])->name('VacataireAccount.addVacataire');
    Route::post('/Coordinator/AddVacataire', [CoordinatorController::class, 'AddVacataireDb'])->name('VacataireAccount.addVacataireDB');
});

Route::prefix('professor')
    ->name('professor.')
//    ->middleware(['auth', 'role:professor'])
    ->group(function () {
    Route::get('/{id}/request-units', [ProfessorController::class, 'unitRequestForm'])->name('units.request');
    Route::post('/{id}/request-units', [ProfessorController::class, 'storeRequest'])->name('units.request.store');
});





Route::get('/TeachingStuff/{id}/Assignments', [TeachingStaffController::class, 'ShowAssignments'])->name('TeachingStuff.Assignments');






Route::get('/user/{id?}', function ($id ="0") {
    return view('user', ['id' => $id]);
});
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/courses', function () {
    return view('courses');
});
Route::get('/re-enrollment', function () {
    return view('re-enrollment');
});
Route::get('/requests', function () {
    return view('requests');
});
Route::get('/grades', function () {
    return view('grades');
});
Route::get('/prof-details', function () {
    return view('prof-details');
});



