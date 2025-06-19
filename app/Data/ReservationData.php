<?php

declare(strict_types=1);


namespace App\Data;

use App\Models\Reservation;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class ReservationData extends DataTransferObject
{
    public ?int $id;
    public int $userId;
    public int $spaceId;
    public int $seatId;
    public string $fromDate;
    public string $toDate;
    public Carbon $createdAt;

    public SpaceData $space;

    public static function fromModel(Reservation $reservation): self
    {
        return new self(
            id: $reservation->id,
            userId: $reservation->user_id,
            spaceId: $reservation->space_id,
            seatId: $reservation->seat_id,
            fromDate: $reservation->from_date,
            toDate: $reservation->to_date,
            createdAt: $reservation->created_at,
            space: SpaceData::fromModel($reservation->space)
        );
    }
}
