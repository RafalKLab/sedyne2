<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Data\SpaceData;
use App\Models\Space;

class SpaceRepository
{
    /**
     * @return SpaceData[]
     */
    public function findAll(): array
    {
        return Space::all()->map([SpaceData::class, 'fromModel'])->all();
    }

    public function find(int $id): ?SpaceData
    {
        $space = Space::with('seats')->find($id);

        return $space ? SpaceData::fromModel($space) : null;
    }
}
