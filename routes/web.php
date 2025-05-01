<?php


use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\LoginProcesse;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\TeachingStaffController;
use App\Http\Controllers\TeachingUnitController;
use App\Http\Controllers\VacataireController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginProcesse::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginProcesse::class, 'login'])->name('login');
Route::post('/logout', [LoginProcesse::class, 'logout'])->name('logout');


Route::middleware('admin')->group(function () {
    Route::get('/Admin/UserManagement', [AdminController::class, 'search'])->name('UserManagement.search');
    Route::get('/Admin/UserManagement/user/{id}', [AdminController::class, 'UserInformation'])->name('UserManagement.user');
    Route::put('/Admin/UserManagement/user/{id}/edit', [AdminController::class, 'EditUser'])->name('UserManagement.editUser');
    Route::get('/Admin/UserManagement/AddUser', [AdminController::class, 'AddUser'])->name('UserManagement.adduser');
    Route::post('/Admin/UserManagement/AddUser', [AdminController::class, 'AddUserDb'])->name('UserManagement.adduserDB');
    Route::delete('/Admin/UserManagement/DeleteUser/{id}', [AdminController::class, 'DeleteUser'])->name('UserManagement.deleteUser');
    Route::delete('/Admin/UserManagement/assignment/{id}', [AdminController::class, 'DeleteAssignment'])->name('UserManagement.deleteAssignment');

    //Logs


    Route::get('/Admin/logs', [AdminController::class, 'sort'])->name('logs.sort');
    Route::get('/logs/export', [AdminController::class, 'export'])->name('logs.export');
});


// Group all routes under '/department-head/'
Route::middleware('departmenthead')->group(function () {
    Route::prefix('department-head')->name('department-head.')->group(function () {
        // ----------------------- Department Head Routes ----------------------
        // show professors workload
        Route::get('professors/workload', [DepartmentHeadController::class, 'workloadOverview'])->name('workload.overview');
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

        // show professors units requests
        Route::get('/professors/unit-requests', [ProfessorController::class, 'indexUnitRequests'])->name('professors.unit.requests');

        // handle(accept or reject) professor unit request
        Route::post('/professors/{unit_request_id}/handle', [ProfessorController::class, 'handleUnitRequests'])->name('professors.unit.request.handle');

    });
});


Route::middleware(['coordinator'])->group(function () {

    Route::get('/Coordinator/teachingUnits', [CoordinatorController::class, 'teachingUnits'])->name('Coordinator.teachingUnits');
    Route::post('/Coordinator/teachingUnits/AddUnit', [CoordinatorController::class, 'AddUnit'])->name('Coordinator.AddUnit');
    Route::post('/Coordinator/teachingUnits/EditUnit', [CoordinatorController::class, 'EdtUnit'])->name('Coordinator.EditUnit');

    Route::get('/vacataire/{id}', [CoordinatorController::class, 'getVacataireDetails']);

    Route::get('/Coordinator/teachingUnits/AssignedTeachingUnit/{id}', [CoordinatorController::class, 'AssignedTeachingUnit'])->name('Coordinator.AssignedTeachingUnit');
    Route::post('/Coordinator/teachingUnits/AssignedTeachingUnit', [CoordinatorController::class, 'AssignedTeachingUnitDB'])->name('Coordinator.AssignedTeachingUnitDB');

    Route::get('/Coordinator/teachingUnits/ReAssignedTeachingUnit/{id}', [CoordinatorController::class, 'ReAssignedTeachingUnit'])->name('Coordinator.ReAssignedTeachingUnit');
    Route::post('/Coordinator/teachingUnits/ReAssignedTeachingUnit', [CoordinatorController::class, 'ReAssignedTeachingUnitDB'])->name('Coordinator.ReAssignedTeachingUnitDB');

    Route::get('/Coordinator/VacataireAccount', [CoordinatorController::class, 'VacataireAccount'])->name('VacataireAccount');
    Route::get('/Coordinator/VacataireAccount/vacataire/{id}', [CoordinatorController::class, 'VacataireInformation'])->name('VacataireAccount.user');

    Route::get('/Coordinator/AddVacataire', [CoordinatorController::class, 'AddVacataire'])->name('VacataireAccount.addVacataire');
    Route::post('/Coordinator/AddVacataire', [CoordinatorController::class, 'AddVacataireDb'])->name('VacataireAccount.addVacataireDB');
    Route::delete('/Coordinator/VacataireAccount/DeleteVacataire', [CoordinatorController::class, 'DeleteVacataire'])->name('VacataireAccount.deleteVacataire');

    //ScheduleManagement Routes
    Route::get('/Coordinator/ScheduleManagement', [CoordinatorController::class, 'ScheduleManagement'])->name('Coordinator.ScheduleManagement');
    Route::get('/coordinator/ScheduleManagement/{name}', [CoordinatorController::class, 'ScheduleManagementFiliere'])->name('coordinator.ScheduleManagementFiliere');
    Route::post('/coordinator/ScheduleManagement/{filiere}/import', [CoordinatorController::class, 'ScheduleManagementFiliereImport'])->name('coordinator.ScheduleManagementFiliere.import');

    //Exporting
    Route::get('/export-user/{id?}', [CoordinatorController::class, 'exportUsers'])->name('export.users');
    Route::get('/coordinator/schedule/export/{filiere}/{semester}', [CoordinatorController::class, 'exportSchedule'])->name('coordinator.ScheduleManagementFiliere.export');


});

Route::prefix('professor')
    ->name('professor.')
//    ->middleware(['auth', 'role:professor'])
    ->group(function () {
    Route::get('/{id}/request-units', [ProfessorController::class, 'unitRequestForm'])->name('units.request');
    Route::post('/{id}/request-units', [ProfessorController::class, 'storeRequest'])->name('units.request.store');
});

Route::get('/TeachingStuff/{id}/Assignments', [TeachingStaffController::class, 'ShowAssignments'])->name('TeachingStuff.Assignments');




Route::get('/Vacataire/assignedUnit', [VacataireController::class, 'assignedUnit'])->name('Vacataire.assignedUnit');
Route::get('/Vacataire/assessments', [VacataireController::class, 'assessments'])->name('Vacataire.assessments');
Route::get('/Vacataire/new-assessments', [VacataireController::class, 'NewAssessments'])->name('Vacataire.AddAssessments');
Route::post('/Vacataire/new-assessments/store', [VacataireController::class, 'NewAssessmentsDB'])->name('Vacataire.AddAssessmentsDB');

Route::post('/Vacataire/NormalGrades', [VacataireController::class, 'UploadNormalGrade'])->name('Vacataire.grades.upload');
Route::post('/Vacataire/NewNormalGrades', [VacataireController::class, 'UploadNewNormalGrade'])->name('Vacataire.NewGrades.upload');

Route::post('/Vacataire/RetakeGrades', [VacataireController::class, 'UploadRetakeGrade'])->name('Vacataire.Retakegrades.upload');
Route::post('/Vacataire/NewRetakeGrades', [VacataireController::class, 'UploadNewRetakeGrade'])->name('Vacataire.NewRetakegrades.upload');
Route::post('/Vacataire/Grades', [VacataireController::class, 'ExportGrade'])->name('Vacataire.grades.export');







Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('Profile');







