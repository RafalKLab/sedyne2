<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(protected ReservationService $reservationService) {}

    public function index(): View
    {
        $reservations = $this->reservationService->getReservationsByUser(auth()->id());

        return view('reservation.index', compact('reservations'));
    }

    public function create(): View
    {
        return view('reservation.create');
    }
}
