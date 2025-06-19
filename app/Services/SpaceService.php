<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\SpaceData;
use App\Repositories\SpaceRepository;

class SpaceService
{
    public function __construct(
        protected SpaceRepository $repository
    ) {}

    /**
     * @return SpaceData[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function find(int $id): ?SpaceData
    {
        return $this->repository->find($id);
    }
}
