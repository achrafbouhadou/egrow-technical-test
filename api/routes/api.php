<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/projects/{project}/issues-summary', [ProjectController::class, 'issuesSummary']);

Route::get('/issues', [IssueController::class, 'index']);
