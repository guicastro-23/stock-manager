<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use App\Models\ContagemEstoque;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'totalContagens' => ContagemEstoque::count(),

            'emAndamento' => ContagemEstoque::where(
                'status',
                'EM_ANDAMENTO'
            )->count(),

            'finalizadas' => ContagemEstoque::where(
                'status',
                'FINALIZADA'
            )->count(),
        ]);
    }
}
