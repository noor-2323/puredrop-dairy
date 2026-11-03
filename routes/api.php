<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\DB;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.token')->group(function () {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/leads', [LeadController::class, 'store']);
    Route::put('/leads/{id}', [LeadController::class, 'update']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);

    Route::get('/db-check-noor', function () {
        try {
            DB::connection()->getPdo();

            return response()->json([
                'status' => 'success',
                'message' => 'Database connection successful.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'exception' => get_class($e),
                'message' => $e->getMessage(),
            ], 500);
        }
    });
});