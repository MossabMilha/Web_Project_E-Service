<?php

use App\Http\Controllers\{
    AdminController,
    CoordinatorController,
    DepartmentHeadController,
    LoginProcesse,
    ProfessorController,
    TeachingStaffController,
    TeachingUnitController,
    VacataireController
};
use Illuminate\Support\Facades\{Auth, Route};

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginProcesse::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginProcesse::class, 'login'])->name('login');
Route::post('/logout', [LoginProcesse::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->group(function () {
    // User Management
    Route::prefix('Admin/UserManagement')->name('UserManagement.')->group(function () {
        Route::get('/', [AdminController::class, 'search'])->name('search');
        Route::get('/user/{id}', [AdminController::class, 'UserInformation'])->name('user');
        Route::put('/user/{id}/edit', [AdminController::class, 'EditUser'])->name('editUser');
        Route::get('/AddUser', [AdminController::class, 'AddUser'])->name('adduser');
        Route::post('/AddUser', [AdminController::class, 'AddUserDb'])->name('adduserDB');
        Route::delete('/DeleteUser/{id}', [AdminController::class, 'DeleteUser'])->name('deleteUser');
        Route::delete('/assignment/{id}', [AdminController::class, 'DeleteAssignment'])->name('deleteAssignment');
    });

    // Logs Management
    Route::get('/Admin/logs', [AdminController::class, 'sort'])->name('logs.sort');
    Route::get('/logs/export', [AdminController::class, 'export'])->name('logs.export');
});

/*
|--------------------------------------------------------------------------
| Department Head Routes
|--------------------------------------------------------------------------
*/
Route::middleware('departmenthead')
    ->prefix('department-head')
    ->name('department-head.')
    ->group(function () {
        // Workload Management
        Route::get('professors/workload', [DepartmentHeadController::class, 'workloadOverview'])->name('workload.overview');

        // Teaching Units Management
        Route::get('/teaching-units', [TeachingUnitController::class, 'index'])->name('teaching-units.index');
        Route::get('/teaching-units/search', [TeachingUnitController::class, 'search'])->name('teaching-units.search');

        // Professors Management
        Route::prefix('professors')->name('professors.')->group(function () {
            Route::get('/', [ProfessorController::class, 'index'])->name('index');
            Route::get('/{id}/assign', [ProfessorController::class, 'assign'])->name('assign');
            Route::post('/{id}/assign', [ProfessorController::class, 'storeAssignment'])->name('units.store');
            Route::delete('/{professor_id}/units/{unit_id}', [ProfessorController::class, 'destroyAssignment'])->name('units.destroy');
            Route::get('/unit-requests', [ProfessorController::class, 'indexUnitRequests'])->name('unit.requests');
            Route::post('/{unit_request_id}/handle', [ProfessorController::class, 'handleUnitRequests'])->name('unit.request.handle');
        });
    });

/*
|--------------------------------------------------------------------------
| Coordinator Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['coordinator'])
    ->prefix('Coordinator')
    ->name('Coordinator.')
    ->group(function () {
        // Teaching Units Management
        Route::prefix('teachingUnits')->group(function () {
            Route::get('/', [CoordinatorController::class, 'teachingUnits'])->name('teachingUnits');
            Route::post('/AddUnit', [CoordinatorController::class, 'AddUnit'])->name('AddUnit');
            Route::post('/EditUnit', [CoordinatorController::class, 'EdtUnit'])->name('EditUnit');
            Route::get('/AssignedTeachingUnit/{id}', [CoordinatorController::class, 'AssignedTeachingUnit'])->name('AssignedTeachingUnit');
            Route::post('/AssignedTeachingUnit', [CoordinatorController::class, 'AssignedTeachingUnitDB'])->name('AssignedTeachingUnitDB');
            Route::get('/ReAssignedTeachingUnit/{id}', [CoordinatorController::class, 'ReAssignedTeachingUnit'])->name('ReAssignedTeachingUnit');
            Route::post('/ReAssignedTeachingUnit', [CoordinatorController::class, 'ReAssignedTeachingUnitDB'])->name('ReAssignedTeachingUnitDB');
        });

        // Vacataire Management
        Route::prefix('VacataireAccount')->name('VacataireAccount.')->group(function () {
            Route::get('/', [CoordinatorController::class, 'VacataireAccount'])->name('index');
            Route::get('/vacataire/{id}', [CoordinatorController::class, 'VacataireInformation'])->name('user');
            Route::get('/AddVacataire', [CoordinatorController::class, 'AddVacataire'])->name('addVacataire');
            Route::post('/AddVacataire', [CoordinatorController::class, 'AddVacataireDb'])->name('addVacataireDB');
            Route::delete('/DeleteVacataire', [CoordinatorController::class, 'DeleteVacataire'])->name('deleteVacataire');
        });

        // Schedule Management
        Route::prefix('ScheduleManagement')->group(function () {
            Route::get('/', [CoordinatorController::class, 'ScheduleManagement'])->name('ScheduleManagement');
            Route::get('/{name}', [CoordinatorController::class, 'ScheduleManagementFiliere'])->name('ScheduleManagementFiliere');
            Route::post('/{filiere}/import', [CoordinatorController::class, 'ScheduleManagementFiliereImport'])->name('ScheduleManagementFiliere.import');
        });

        // Export Routes
        Route::get('/export-user/{id?}', [CoordinatorController::class, 'exportUsers'])->name('export.users');
        Route::get('/schedule/export/{filiere}/{semester}', [CoordinatorController::class, 'exportSchedule'])->name('ScheduleManagementFiliere.export');
    });

/*
|--------------------------------------------------------------------------
| Professor Routes
|--------------------------------------------------------------------------
*/
Route::prefix('professor')
    ->name('professor.')
    ->group(function () {
        Route::get('/{id}/request-units', [ProfessorController::class, 'unitRequestForm'])->name('units.request');
        Route::post('/{id}/request-units', [ProfessorController::class, 'storeRequest'])->name('units.request.store');
    });

/*
|--------------------------------------------------------------------------
| Teaching Staff Routes
|--------------------------------------------------------------------------
*/
Route::get('/TeachingStuff/{id}/Assignments', [TeachingStaffController::class, 'ShowAssignments'])->name('TeachingStuff.Assignments');

/*
|--------------------------------------------------------------------------
| Vacataire Routes
|--------------------------------------------------------------------------
*/
Route::prefix('Vacataire')->name('Vacataire.')->group(function () {
    // Unit and Assessment Management
    Route::get('/assignedUnit', [VacataireController::class, 'assignedUnit'])->name('assignedUnit');
    Route::get('/assessments', [VacataireController::class, 'assessments'])->name('assessments');
    Route::get('/new-assessments', [VacataireController::class, 'NewAssessments'])->name('AddAssessments');
    Route::post('/new-assessments/store', [VacataireController::class, 'NewAssessmentsDB'])->name('AddAssessmentsDB');

    // Grades Management
    Route::post('/NormalGrades', [VacataireController::class, 'UploadNormalGrade'])->name('grades.upload');
    Route::post('/NewNormalGrades', [VacataireController::class, 'UploadNewNormalGrade'])->name('NewGrades.upload');
    Route::post('/RetakeGrades', [VacataireController::class, 'UploadRetakeGrade'])->name('Retakegrades.upload');
    Route::post('/NewRetakeGrades', [VacataireController::class, 'UploadNewRetakeGrade'])->name('NewRetakegrades.upload');
    Route::post('/Grades', [VacataireController::class, 'ExportGrade'])->name('grades.export');
});

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect()->route('login')->withErrors(['error' => 'Access denied']);
    }
    return view('home');
})->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('Profile');
