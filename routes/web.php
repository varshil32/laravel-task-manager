<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

// Registration routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TaskController::class, 'index'])
        ->name('dashboard');

    Route::get('/add', function () {
        return view('add');
    })->middleware('permission:add-task')->name('add');

    Route::post('/addtask', [TaskController::class, 'add'])
        ->middleware('permission:add-task')
        ->name('addtask');

    Route::post('/update/{id}', [TaskController::class, 'update'])
        ->middleware('permission:edit-task')
        ->name('update');

    Route::get('/edit/{id}', [TaskController::class, 'edit'])
        ->middleware('permission:edit-task')
        ->name('edit');

    Route::delete('/delete/{id}', [TaskController::class, 'delete'])
        ->middleware('permission:delete-task')
        ->name('delete');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class,'index'])->name('admin.index');
    Route::get('/admin/edit/{id}', [AdminController::class,'edit'])->name('edituser');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteuser'])->name('deleteuser');

    Route::get('/admin/role', [RoleController::class, 'index'])->name('admin.role');
    Route::get('/admin/role/create', [RoleController::class, 'create'])->name('admin.role.add');
    Route::post('/admin/role/store', [RoleController::class, 'store'])->name('admin.role.store');
    Route::delete('/admin/role/delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');
    Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.show');
    Route::post('/admin/role/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
    Route::post('/admin/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('admin.role.permission');
    Route::delete('/admin/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('admin.role.revoke');

    Route::get('/admin/permission', [PermissionController::class, 'index'])->name('admin.permission');
    Route::get('/admin/permission/create', [PermissionController::class, 'create'])->name('admin.permission.add');
    Route::post('/admin/permission/store', [PermissionController::class, 'store'])->name('admin.permission.store');
    Route::delete('/admin/permission/delete/{id}', [PermissionController::class, 'delete'])->name('admin.permission.delete');
    Route::get('/admin/permission/edit/{id}', [PermissionController::class, 'edit'])->name('admin.permission.show');
    Route::post('/admin/permission/update/{id}', [PermissionController::class, 'update'])->name('admin.permission.update');
    Route::post('/admin/permissions/{permission}/roles', [PermissionController::class, 'giveRole'])->name('admin.permission.role');
    Route::delete('/admin/permissions/{permission}/roles/{role}', [PermissionController::class, 'revokeRole'])->name('admin.permission.revoke');
    Route::post('/admin/users/{user}/roles', [AdminController::class, 'assignRole'])->name('admin.users.role');
    Route::delete('/admin/users/{user}/roles/{role}', [AdminController::class, 'revokeRole'])->name('admin.users.revokerole');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
