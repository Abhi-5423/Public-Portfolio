<?php namespace App\Repositories\Interfaces;
interface ContactRepositoryInterface { public function all(): array; public function find(string $id): ?array; public function save(array $data): string; public function delete(string $id): bool; public function count(): int; }
