<?php

declare(strict_types=1);


namespace App\Data;

use Spatie\DataTransferObject\DataTransferObject;

class ReservationCreateData extends DataTransferObject
{
    public ?int $id;
    public int $userId;
    public int $spaceId;
    public int $seatId;
    public string $fromDate;
    public string $toDate;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'space_id' => $this->spaceId,
            'seat_id' => $this->seatId,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
        ];
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}

