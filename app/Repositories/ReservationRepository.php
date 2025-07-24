<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\ReservationCreateData;
use App\Data\ReservationData;
use App\Models\Reservation;

class ReservationRepository
{
    public function getReservationsBySpaceAndDate(int $spaceId, string $date): array
    {
        return Reservation::whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date)
            ->whereHas('seat', function ($query) use ($spaceId) {
                $query->where('space_id', $spaceId);
            })
            ->with(['user:id,name'])
            ->get()
            ->toArray();
    }

    public function getReservationsByUser(int $id): array
    {
        return Reservation::where('user_id', $id)
            ->with('space')
            ->get()
            ->map(fn($reservation) => ReservationData::fromModel($reservation))
            ->all();
    }

    public function getReservationConflicts(int $selectedSeatId, string $dateFrom, string $dateTo): array
    {
        return Reservation::where('seat_id', $selectedSeatId)
            ->where(function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('from_date', [$dateFrom, $dateTo])
                    ->orWhereBetween('to_date', [$dateFrom, $dateTo])
                    ->orWhere(function ($subQuery) use ($dateFrom, $dateTo) {
                        $subQuery->where('from_date', '<=', $dateFrom)
                            ->where('to_date', '>=', $dateTo);
                    });
            })
            ->get()
            ->toArray();
    }

    public function createReservation(ReservationCreateData $reservationCreateTransfer): ReservationCreateData
    {
        $reservation = Reservation::create($reservationCreateTransfer->toArray());

        return $reservationCreateTransfer->setId($reservation->id);
    }
}
