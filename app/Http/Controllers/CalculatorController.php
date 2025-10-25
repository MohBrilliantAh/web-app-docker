<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    /**
     * Tampilkan halaman kalkulator.
     * Metode ini dipanggil ketika route /kalkulator diakses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengembalikan file view 'calculator.blade.php'
        // Pastikan file ini ada di resources/views/calculator.blade.php
        return view('calculator');
    }
}
