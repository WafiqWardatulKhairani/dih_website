<?php

namespace App\Repositories;

use App\Models\AcademicInnovation;
use Illuminate\Support\Facades\Auth;

class EloquentAcademicInnovationRepository implements AcademicInnovationRepositoryInterface
{
    public function paginateUserInnovations(int $userId, array $filters = [], int $perPage = 12)
    {
        $query = AcademicInnovation::where('user_id', $userId);

        if (!empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    public function getUserInnovationsGroupedByYear(int $userId, int $excludeId = null)
    {
        $query = AcademicInnovation::where('user_id', $userId);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->orderByDesc('created_at')->get()->groupBy(fn($item) => $item->created_at->format('Y'));
    }

    public function getTrendingInnovations(int $limit = 6)
    {
        return AcademicInnovation::where('status', AcademicInnovation::STATUS_PUBLICATION)
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }

    public function create(array $data)
    {
        return AcademicInnovation::create($data);
    }

    public function findById(int $id)
    {
        return AcademicInnovation::findOrFail($id);
    }

    public function modelClass(): string
    {
        return AcademicInnovation::class;
    }

    public function validStatuses(): array
    {
        return AcademicInnovation::statuses();
    }
}
