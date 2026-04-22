<?php
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;



Route::post('/create-lead', [LeadController::class, 'createLead']);
