<?php

namespace App\Repositories;

interface AcademicInnovationRepositoryInterface
{
    public function paginateUserInnovations(int $userId, array $filters = [], int $perPage = 12);
    
    public function getUserInnovationsGroupedByYear(int $userId, int $excludeId = null);

    public function getTrendingInnovations(int $limit = 6);

    public function create(array $data);

    public function findById(int $id);

    public function modelClass(): string;

    public function validStatuses(): array;
}
