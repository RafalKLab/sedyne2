<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\ReservationCreateData;
use App\Repositories\ReservationRepository;

class ReservationService
{
    public function __construct(
        protected ReservationRepository $repository
    ) {}

    public function getReservationsBySpaceAndDate(int $spaceId, string $date): array
    {
        return $this->repository->getReservationsBySpaceAndDate($spaceId, $date);
    }

    public function getReservationsByUser(int $id): array
    {
        return $this->repository->getReservationsByUser($id);
    }

    public function getReservationConflicts(int $selectedSeatId, string $dateFrom, string $dateTo): array
    {
        return $this->repository->getReservationConflicts($selectedSeatId, $dateFrom, $dateTo);
    }

    public function createReservation(ReservationCreateData $reservationCreateTransfer): ReservationCreateData
    {
        return $this->repository->createReservation($reservationCreateTransfer);
    }
}
