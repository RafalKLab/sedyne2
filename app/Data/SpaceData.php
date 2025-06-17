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
    public Carbon $createdAt;

    public static function fromModel(Space $space): self
    {
        return new self(
            id: $space->id,
            name: $space->name,
            createdAt: $space->created_at,
        );
    }
}
