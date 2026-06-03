<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\InventoryController;
use App\Http\Controllers\Front\CrmController;
use App\Http\Controllers\Front\TransactionController;
use App\Http\Controllers\Front\ReportController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('front.dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('front.dashboard');
});

Route::get('/inventory', [InventoryController::class, 'index'])
    ->name('front.inventory.index');

Route::get('/crm', [CrmController::class, 'index'])
    ->name('front.crm.index');

Route::get('/transactions', [TransactionController::class, 'index'])
    ->name('front.transactions.index');

Route::get('/reports', [ReportController::class, 'index'])
    ->name('front.reports.index');
