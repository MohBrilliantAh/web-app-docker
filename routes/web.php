<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController; // Import Controller yang baru kita buat

// Rute default yang menampilkan halaman Laravel standar
Route::get('/', function () {
    return view('calculator');
});