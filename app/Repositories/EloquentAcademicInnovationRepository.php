<?php

namespace App\Repositories;

use App\Models\AcademicInnovation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function update($id, array $data)
    {
        $innovation = AcademicInnovation::findOrFail($id);

        // Handle file uploads
        if (isset($data['image_path']) && $data['image_path'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old image if exists
            if ($innovation->image_path) {
                Storage::delete('public/' . $innovation->image_path);
            }
            $data['image_path'] = $data['image_path']->store('innovations/images', 'public');
        } else {
            unset($data['image_path']);
        }

        if (isset($data['document_path']) && $data['document_path'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old document if exists
            if ($innovation->document_path) {
                Storage::delete('public/' . $innovation->document_path);
            }
            $data['document_path'] = $data['document_path']->store('innovations/documents', 'public');
        } else {
            unset($data['document_path']);
        }

        // Update the innovation
        $innovation->update($data);

        return $innovation;
    }

    public function delete($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        
        // Delete associated files
        if ($innovation->image_path) {
            Storage::delete('public/' . $innovation->image_path);
        }
        if ($innovation->document_path) {
            Storage::delete('public/' . $innovation->document_path);
        }
        
        return $innovation->delete();
    }

    public function find($id)
    {
        return $this->findById($id);
    }

    public function modelClass(): string
    {
        return AcademicInnovation::class;
    }

    public function validStatuses(): array
    {
        return AcademicInnovation::statuses();
    }

    public function getAllCategories()
    {
        return [
            'Teknologi',
            'Sosial', 
            'Pendidikan',
            'Humaniora'
        ];
    }

    public function getSubcategoriesByCategory(string $category)
    {
        $subcategories = [
            'Teknologi' => [
                'Artificial Intelligence',
                'Internet of Things',
                'Sistem Informasi Akademik',
                'Robotics',
                'Biotechnology',
            ],
            'Sosial' => [
                'Kewirausahaan Sosial',
                'Pemberdayaan Masyarakat',
                'Inklusi Sosial',
                'Pengentasan Kemiskinan',
            ],
            'Pendidikan' => [
                'EdTech',
                'Metode Pembelajaran',
                'Kurikulum',
                'Assesmen Pendidikan',
            ],
            'Humaniora' => [
                'Psikologi',
                'Seni & Budaya',
                'Filsafat',
                'Sejarah',
                'Antropologi',
            ]
        ];

        return $subcategories[$category] ?? [];
    }
}