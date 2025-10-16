<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
    ])->onlyInput('email');
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/copilot', function () {
        return view('admin.copilot');
    })->name('admin.copilot');

    Route::get('/integracoes', function () {
        $integrationCategories = \App\Models\IntegrationCategory::query()
            ->with('integrations')
            ->where('is_active', true)
            ->get();
        
        return view('admin.integracoes', compact('integrationCategories'));
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
