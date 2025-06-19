<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Space;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class SpaceData extends DataTransferObject
{
    public int $id;
    public string $name;
    public ?array $layout;
    public array $seats;
    public Carbon $createdAt;

    public static function fromModel(Space $space): self
    {
        $layout = $space->layout;

        if (is_string($layout)) {
            $layout = json_decode($layout, true);
        }

        return new self(
            id: $space->id,
            name: $space->name,
            createdAt: $space->created_at,
            layout: $layout,
            seats: $space->seats?->toArray(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->createdAt->toDateTimeString(),
            'layout' => $this->layout,
            'seats' => $this->seats,
        ];
    }
}
