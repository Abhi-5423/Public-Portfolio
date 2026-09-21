<?php namespace App\Config;

use Dotenv\Dotenv;

final class Env
{
    public static function load(string $root): void
    {
        $file = $root.'/.env';
        if (!is_file($file)) {
            return;
        }

        if (class_exists(Dotenv::class)) {
            Dotenv::createImmutable($root)->safeLoad();
            return;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $line, 2));
            $value = trim($value, "\"'");
            $_ENV[$key] = $value;
            putenv($key.'='.$value);
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}
