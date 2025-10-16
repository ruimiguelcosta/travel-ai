<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('admin.dashboard');
})->name('login.post');

Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/copilot', function () {
        return view('admin.copilot');
    })->name('admin.copilot');
    
    Route::get('/integracoes', function () {
        return view('admin.integracoes');
    })->name('admin.integracoes');
    
    Route::get('/orcamento', function () {
        return view('admin.orcamento');
    })->name('admin.orcamento');
    
    Route::get('/pos-venda', function () {
        return view('admin.pos-venda');
    })->name('admin.pos-venda');
    
    Route::get('/clientes', function () {
        return view('admin.clientes');
    })->name('admin.clientes');
});
