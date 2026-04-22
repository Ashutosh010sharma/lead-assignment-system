<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/create-lead', [LeadController::class, 'createLead']);
Route::get('/', function () {
    return view('create-lead');
});
Route::get('/leads', [LeadController::class, 'listLeads']);

Route::get('/add-user', [LeadController::class, 'create']);
Route::post('/store-user', [LeadController::class, 'store']);
Route::get('/employees-load', [LeadController::class, 'employeesLoad']);
Route::post('/update-lead-status', [LeadController::class, 'updateStatus']);
Route::get('/users', [LeadController::class, 'userList']);
Route::post('/toggle-user-status', [LeadController::class, 'toggleStatus']);
