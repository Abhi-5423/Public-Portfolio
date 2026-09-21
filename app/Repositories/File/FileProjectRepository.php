<?php namespace App\Repositories\File;

use App\Repositories\Interfaces\ProjectRepositoryInterface;

final class FileProjectRepository extends FileRepository implements ProjectRepositoryInterface
{
    public function all(): array
    {
        $rows = $this->rows('projects');
        usort($rows, static fn (array $a, array $b): int => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $rows;
    }

    public function featured(int $limit = 3): array
    {
        return array_slice(array_values(array_filter($this->all(), static fn (array $row): bool => !empty($row['featured']))), 0, $limit);
    }

    public function find(string $id): ?array
    {
        return $this->findRow('projects', $id);
    }

    public function save(array $data, ?string $id = null): string
    {
        $now = date('Y-m-d H:i:s');
        $row = [
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'short_description' => $data['short_description'] ?? '',
            'technologies' => $data['technologies'] ?? '',
            'github_url' => $data['github_url'] ?? '',
            'live_url' => $data['live_url'] ?? '',
            'image' => $data['image'] ?? '',
            'featured' => (bool)($data['featured'] ?? false),
            'updated_at' => $now,
        ];

        if (!$id) {
            $row['created_at'] = $now;
        }

        return $this->saveRow('projects', $row, $id);
    }

    public function delete(string $id): bool
    {
        return $this->deleteRow('projects', $id);
    }

    public function count(): int
    {
        return count($this->rows('projects'));
    }
}
