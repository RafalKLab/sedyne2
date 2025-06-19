<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        return view('reservation.index');
    }

    public function create(): View
    {
        return view('reservation.create');
    }
}
