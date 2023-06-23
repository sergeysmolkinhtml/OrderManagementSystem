<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TenantController;
use App\Http\Livewire\CategoriesList;
use App\Http\Livewire\OrderForm;
use App\Http\Livewire\OrdersList;
use App\Http\Livewire\ProductForm;
use App\Http\Livewire\ProductsList;
use App\Http\Livewire\UsersList;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('categories', CategoriesList::class)->name('categories.index');

    Route::get('users', UsersList::class)
        ->name('users.index')
        ->middleware('can:manage_users');

    Route::post('users', [UsersList::class, 'sendInvitation'])->name('users.sendInvitation');

    Route::resource('tasks', TaskController::class);
    Route::resource('projects', ProjectController::class);

    Route::get('products', ProductsList::class)->name('products.index');
    Route::get('products/create', ProductForm::class)->name('products.create');
    Route::get('products/{product}', ProductForm::class)->name('products.edit');

    Route::get('orders', OrdersList::class)->name('orders.index');
    Route::get('orders/create', OrderForm::class)->name('orders.create');
    Route::get('orders/{order}', OrderForm::class)->name('orders.edit');

    Route::get('tenants/change/{tenantID}', [TenantController::class, 'changeTenant'])->name('tenants.change');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('invitations/{token}',[UsersList::class, 'acceptInvitation'])->name('invitation.accept');

require __DIR__.'/auth.php';
