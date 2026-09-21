<?php namespace App\Repositories\File;

use App\Repositories\Interfaces\ContactRepositoryInterface;

final class FileContactRepository extends FileRepository implements ContactRepositoryInterface
{
    public function all(): array
    {
        $rows = $this->rows('contacts');
        usort($rows, static fn (array $a, array $b): int => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $rows;
    }

    public function find(string $id): ?array
    {
        return $this->findRow('contacts', $id);
    }

    public function save(array $data): string
    {
        return $this->saveRow('contacts', [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'subject' => $data['subject'] ?? '',
            'message' => $data['message'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function delete(string $id): bool
    {
        return $this->deleteRow('contacts', $id);
    }

    public function count(): int
    {
        return count($this->rows('contacts'));
    }
}
