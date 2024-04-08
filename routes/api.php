<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\organizationvmsController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\VmsUserController;
use App\Http\Middleware\usertoken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */
// routes/api.php
Route::post('/users/create', [VmsUserController::class, 'create']);
Route::get('/users/getdata', [VmsUserController::class, 'getdata']);
Route::post('/users/update/{id}', [VmsUserController::class, 'update']);
Route::get('/users/getupdate/{id}', [VmsUserController::class, 'getupdate']);
Route::post('/users/update/{id}', [VmsUserController::class, 'getSingleRow']);
Route::get('/users/getSingleRow/{id}', [VmsUserController::class, 'getSingleRow']);
Route::post('/login_user', [VmsUserController::class, 'loginUser']);
Route::get('/login_user', [VmsUserController::class, 'loginUser']);
Route::post('/logout', [VmsUserController::class, 'logout']); 
Route::get('/logout', [VmsUserController::class, 'logout']);
Route::post('/organization_vms/create', [organizationvmsController::class, 'create']);
Route::get('/organization_vms/getdata', [organizationvmsController::class, 'getdata']);
Route::post('/organization_vms/update/{id}', [organizationvmsController::class, 'update']);
Route::get('/organization_vms/getupdate/{id}', [organizationvmsController::class, 'getupdate']);
Route::get('/organization_vms/getSingleRow/{id}', [organizationvmsController::class, 'getSingleRow']);
Route::get('/organization_vms/update/{id}', [organizationvmsController::class, 'update']);
Route::delete('/users/delete/{id}', [organizationvmsController::class, 'destroy']);
Route::post('/employees/create', [EmployeeController::class, 'create'])->middleware(usertoken::class);
Route::get('/employees', [EmployeeController::class, 'getdata'])->middleware(usertoken::class);
Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->middleware(usertoken::class);
Route::get('/employees/getupdate/{id}', [EmployeeController::class, 'getupdate'])->middleware(usertoken::class);
Route::post('/employees/getSingleRow/{id}', [EmployeeController::class, 'getSingleRow'])->middleware(usertoken::class);
Route::get('/employees/getSingleRow/{id}', [EmployeeController::class, 'getSingleRow'])->middleware(usertoken::class);
Route::get('/employees/update/{id}', [EmployeeController::class, 'update'])->middleware(usertoken::class);
Route::post('/Department/create', [DepartmentController::class, 'create'])->middleware(usertoken::class);
Route::get('/Department', [DepartmentController::class, 'getdata'])->middleware(usertoken::class);
Route::post('/Department/update/{id}', [DepartmentController::class, 'update'])->middleware(usertoken::class);
Route::get('/Department/getupdate/{id}', [DepartmentController::class, 'getupdate'])->middleware(usertoken::class);
Route::get('/Department/getSingleRow/{id}', [DepartmentController::class, 'getSingleRow'])->middleware(usertoken::class);
Route::post('/Department/getSingleRow/{id}', [DepartmentController::class, 'getSingleRow'])->middleware(usertoken::class);
Route::delete('/Department/{id}', [DepartmentController::class, 'destroy']);
Route::post('/designations/create', [DesignationController::class, 'create'])->middleware(usertoken::class);
Route::get('/designations/getdata', [DesignationController::class, 'getdata'])->middleware(usertoken::class);
Route::post('/designations/update/{id}', [DesignationController::class, 'update'])->middleware(usertoken::class);
Route::get('/designations/getupdate/{id}', [DesignationController::class, 'getupdate'])->middleware(usertoken::class);
Route::get('/designations/getSingleRow/{id}', [DesignationController::class, 'getSingleRow'])->middleware(usertoken::class);
Route::delete('/designations/{id}', [DesignationController::class, 'destroy']);
Route::delete('/employees/{status}/{id}', [EmployeeController::class, 'destroyByStatus']);
Route::delete('/designations/{status}/{id}', [DesignationController::class, 'destroyByStatus']);
Route::delete('/Department/{status}/{id}', [DepartmentController::class, 'destroyByStatus']);
Route::delete('/organization_vms/{status}/{id}', [organizationvmsController::class, 'destroyByStatus']);
Route::delete('/users/{status}/{id}', [VmsUserController::class, 'destroyByStatus']);
Route::post('/visitors/create', [VisitorController::class, 'create'])->middleware(usertoken::class);
Route::get('/visitors/getdata', [VisitorController::class, 'getdata'])->middleware(usertoken::class);
Route::get('/visitors/getSingleRow/{id}', [VisitorController::class, 'getSingleRow'])->middleware(usertoken::class);
Route::put('/visitors/update/{id}', [VisitorController::class, 'update']);
Route::delete('/visitors/{status}/{id}', [VisitorController::class, 'destroyByStatus']);
Route::post('/purposes/create', [PurposeController::class, 'create'])->middleware(usertoken::class);
Route::get('/purposes/getdata', [PurposeController::class, 'getdata'])->middleware(usertoken::class);
Route::put('/purposes/update/{id}', [PurposeController::class, 'update'])->middleware(usertoken::class);
Route::delete('/purposes/{status}/{id}', [PurposeController::class, 'destroyByStatus']);
Route::get('/purposes/getSingleRow/{id}', [PurposeController::class, 'getSingleRow'])->middleware(usertoken::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/', function (Request $request) {
    $key = 'Authorization';
    $header = $request->header($key, '');
    $token = '';
    if (Str::of($header)->startsWith('Bearer')) {
        $token = Str::of($header)->substr(7);
    }
    return $token;
});
