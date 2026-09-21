<?php namespace App\Repositories\File;

use App\Database\FileConnection;

abstract class FileRepository
{
    public function __construct(protected FileConnection $db)
    {
    }

    protected function rows(string $table): array
    {
        return array_values($this->db->all()[$table] ?? []);
    }

    protected function findRow(string $table, string $id): ?array
    {
        foreach ($this->rows($table) as $row) {
            if ((string)($row['id'] ?? '') === $id) {
                return $row;
            }
        }

        return null;
    }

    protected function saveRow(string $table, array $row, ?string $id = null): string
    {
        $data = $this->db->all();
        $id ??= $this->db->nextId($table);
        $row['id'] = $id;
        $updated = false;

        foreach ($data[$table] as $index => $existing) {
            if ((string)($existing['id'] ?? '') === $id) {
                $data[$table][$index] = array_merge($existing, $row);
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $data[$table][] = $row;
        }

        $this->db->write($data);
        return $id;
    }

    protected function deleteRow(string $table, string $id): bool
    {
        $data = $this->db->all();
        $before = count($data[$table]);
        $data[$table] = array_values(array_filter($data[$table], static fn (array $row): bool => (string)($row['id'] ?? '') !== $id));
        $this->db->write($data);
        return count($data[$table]) < $before;
    }
}
