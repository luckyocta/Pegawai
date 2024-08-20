<?php

use Illuminate\Support\Facades\Route;
use App\http\controllers\AuthManager;
use App\Models\Pegawai;

Route::get('/', function () {
    return view('welcome');
})->name(name:'home');
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth'], function(){
    Route::get('/profile', function(){
        return "Heeyy";
    });
    Route::get('/sort/{id}', function ($id)  {
        switch ($id) {
                case 'asc' :
                    return view('pegawai.data', [
                    'pegawai' => Pegawai::orderBy('nama', 'asc')->get(),
                    'sort' => "desc"
                ]);
                case 'desc' :
                    return view('pegawai.data', [
                    'pegawai' => Pegawai::orderBy('nama', 'desc')->get(), 
                    'sort' => "asc" 
                ]);
            }
        });
    Route::get('/pegawai', [AuthManager::class, 'data'])->name('pegawai.data');
    Route::post('/pegawai', [AuthManager::class, 'temp'])->name('pegawai.temp');
    Route::put('/pegawai/{pegawai}', [AuthManager::class, 'edit'])->name('pegawai.edit');
    Route::delete('/pegawai/{pegawai}', [AuthManager::class, 'delete'])->name('pegawai.delete');
});