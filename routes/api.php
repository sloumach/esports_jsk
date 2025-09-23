<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Admin\TeamController;
use App\Http\Controllers\Api\Admin\StaffRoleController;
use App\Http\Controllers\Api\Admin\DisciplineController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Forgot password: send reset link
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => 'Reset link sent'])
        : response()->json(['message' => 'Unable to send reset link'], 400);
})->middleware('guest');

// Reset password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => bcrypt($password)])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => 'Password reset successfully'])
        : response()->json(['message' => 'Invalid token'], 400);
})->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully']);
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/resend', function () {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified']);
        }
        auth()->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent']);
    })->name('verification.send');
});





// Protected
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Users
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

        // Disciplines
    Route::apiResource('disciplines', DisciplineController::class);

    // Teams
    Route::apiResource('teams', TeamController::class);
    Route::post('teams/{team}/players/add', [TeamController::class, 'addPlayer']);
    Route::post('teams/{team}/players/remove', [TeamController::class, 'removePlayer']);
    Route::post('teams/{team}/staff/add', [TeamController::class, 'addStaff']);
    Route::post('teams/{team}/staff/remove', [TeamController::class, 'removeStaff']);

    // Staff roles
    Route::apiResource('staff-roles', StaffRoleController::class)->except(['show']);

    // News
    Route::apiResource('news', NewsController::class);

    // Events
    Route::apiResource('events', EventController::class);

    // Leagues
    Route::apiResource('leagues', LeagueController::class);
    Route::post('leagues/{league}/teams/add', [LeagueController::class, 'addTeam']);
    Route::post('leagues/{league}/teams/remove', [LeagueController::class, 'removeTeam']);
    Route::post('leagues/{league}/teams/points', [LeagueController::class, 'setPoints']);

    // Sponsors
    Route::apiResource('sponsors', SponsorController::class)->except(['show']);

    // Pages
    Route::apiResource('pages', PageController::class);
});
