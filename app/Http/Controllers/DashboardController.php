<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dados = [30, 40, 35, 50, 49, 60, 70, 91, 125];
        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set'];

        return view('dashboard', [
            'dados' => json_encode($dados),
            'meses' => json_encode($meses)
        ]);
    }
}