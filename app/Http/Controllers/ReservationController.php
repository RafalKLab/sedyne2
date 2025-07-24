<?php

declare(strict_types=1);


namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
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

    public function delete(int $idReservation): RedirectResponse
    {
        $response = $this->reservationService->deleteReservation(auth()->id(), $idReservation);

        if ($response['success']) {
            return redirect()->route('reservation.index')->with('success', 'Reservation canceled');
        }

        return redirect()->route('reservation.index')->with('danger', $response['error']);
    }
}
