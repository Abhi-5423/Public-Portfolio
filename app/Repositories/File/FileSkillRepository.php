<?php namespace App\Repositories\File;

use App\Repositories\Interfaces\SkillRepositoryInterface;

final class FileSkillRepository extends FileRepository implements SkillRepositoryInterface
{
    public function all(): array
    {
        $rows = $this->rows('skills');
        usort($rows, static fn (array $a, array $b): int => [$a['sort_order'] ?? 0, $a['name'] ?? ''] <=> [$b['sort_order'] ?? 0, $b['name'] ?? '']);
        return $rows;
    }

    public function find(string $id): ?array
    {
        return $this->findRow('skills', $id);
    }

    public function save(array $data, ?string $id = null): string
    {
        return $this->saveRow('skills', [
            'name' => $data['name'] ?? '',
            'category' => $data['category'] ?? '',
            'proficiency' => (int)($data['proficiency'] ?? 0),
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ], $id);
    }

    public function delete(string $id): bool
    {
        return $this->deleteRow('skills', $id);
    }

    public function count(): int
    {
        return count($this->rows('skills'));
    }
}
