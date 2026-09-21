<?php namespace App\Repositories\Interfaces;
interface AdminRepositoryInterface { public function findByUsername(string $username): ?array; public function save(string $username,string $hash): string; }
