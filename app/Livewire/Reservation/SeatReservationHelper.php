<?php

namespace App\Livewire\Reservation;

use App\Services\ReservationService;
use App\Services\SpaceService;

trait SeatReservationHelper
{
    public string $alertMessage = '';
    public string $alertType = '';

    protected function showDangerAlert(string $message): void
    {
        $this->alertType = 'danger';
        $this->alertMessage = $message;
    }

    protected function showSuccessAlert(string $message = 'Seat is available, you can make reservation'): void
    {
        $this->alertType = 'success';
        $this->alertMessage = $message;
    }

    protected function resetAlert(): void
    {
        $this->alertType = '';
        $this->alertMessage = '';
    }

    protected function getSpaceService(): SpaceService
    {
        return app(SpaceService::class);
    }

    protected function getReservationService(): ReservationService
    {
        return app(ReservationService::class);
    }
}
