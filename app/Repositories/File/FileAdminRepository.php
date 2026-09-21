<?php namespace App\Repositories\File;

use App\Repositories\Interfaces\AdminRepositoryInterface;

final class FileAdminRepository extends FileRepository implements AdminRepositoryInterface
{
    public function findByUsername(string $username): ?array
    {
        foreach ($this->rows('admins') as $admin) {
            if (($admin['username'] ?? '') === $username) {
                return $admin;
            }
        }

        return null;
    }

    public function save(string $username, string $hash): string
    {
        return $this->saveRow('admins', ['username' => $username, 'password_hash' => $hash]);
    }
}
