<?php namespace App\Database;

final class FileConnection implements DatabaseInterface
{
    public function __construct(private string $path)
    {
        $dir = dirname($this->path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        if (!is_file($this->path)) {
            $this->write($this->seed());
        }
    }

    public function driver(): string
    {
        return 'file';
    }

    public function all(): array
    {
        $json = is_file($this->path) ? file_get_contents($this->path) : false;
        $data = $json ? json_decode($json, true) : null;
        return is_array($data) ? $data + $this->empty() : $this->seed();
    }

    public function write(array $data): void
    {
        file_put_contents($this->path, json_encode($data + $this->empty(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
    }

    public function nextId(string $table): string
    {
        $ids = array_map(static fn (array $row): int => (int)($row['id'] ?? 0), $this->all()[$table] ?? []);
        return (string)((max($ids ?: [0])) + 1);
    }

    private function empty(): array
    {
        return ['admins' => [], 'skills' => [], 'projects' => [], 'contacts' => []];
    }

    private function seed(): array
    {
        return [
            'admins' => [
                ['id' => '1', 'username' => 'admin', 'password_hash' => password_hash('Admin@12345', PASSWORD_DEFAULT)],
            ],
            'skills' => [
                ['id' => '1', 'name' => 'PHP', 'category' => 'Backend', 'proficiency' => 88, 'sort_order' => 1],
                ['id' => '2', 'name' => 'JavaScript', 'category' => 'Frontend', 'proficiency' => 82, 'sort_order' => 2],
                ['id' => '3', 'name' => 'HTML & CSS', 'category' => 'Frontend', 'proficiency' => 90, 'sort_order' => 3],
                ['id' => '4', 'name' => 'MySQL', 'category' => 'Databases', 'proficiency' => 80, 'sort_order' => 4],
                ['id' => '5', 'name' => 'MongoDB', 'category' => 'Databases', 'proficiency' => 76, 'sort_order' => 5],
                ['id' => '6', 'name' => 'Git & GitHub', 'category' => 'Tools', 'proficiency' => 85, 'sort_order' => 6],
            ],
            'projects' => [
                ['id' => '1', 'title' => 'Campus Connect', 'description' => 'A student event discovery platform with secure registrations. This project demonstrates practical problem-solving, responsive design, and maintainable code.', 'short_description' => 'Responsive PHP platform for campus communities.', 'technologies' => 'PHP, MySQL, Bootstrap', 'github_url' => 'https://github.com/your-username', 'live_url' => '', 'image' => '', 'featured' => true, 'created_at' => '2026-09-17 10:00:00', 'updated_at' => '2026-09-17 10:00:00'],
                ['id' => '2', 'title' => 'Budget Buddy', 'description' => 'Personal expense tracking dashboard with visual reports. This project demonstrates practical problem-solving, responsive design, and maintainable code.', 'short_description' => 'A clean tracker for managing monthly spending.', 'technologies' => 'JavaScript, Chart.js, MongoDB', 'github_url' => 'https://github.com/your-username', 'live_url' => '', 'image' => '', 'featured' => true, 'created_at' => '2026-09-16 10:00:00', 'updated_at' => '2026-09-16 10:00:00'],
                ['id' => '3', 'title' => 'Secure Notes', 'description' => 'Private note application with authentication and validation. This project demonstrates practical problem-solving, responsive design, and maintainable code.', 'short_description' => 'Security-first notes app for everyday use.', 'technologies' => 'PHP, MongoDB, Sessions', 'github_url' => 'https://github.com/your-username', 'live_url' => '', 'image' => '', 'featured' => true, 'created_at' => '2026-09-15 10:00:00', 'updated_at' => '2026-09-15 10:00:00'],
                ['id' => '4', 'title' => 'Study Planner', 'description' => 'A focused planner for academic goals and tasks. This project demonstrates practical problem-solving, responsive design, and maintainable code.', 'short_description' => 'Organise study sessions and deadlines.', 'technologies' => 'PHP, MySQL, Bootstrap', 'github_url' => 'https://github.com/your-username', 'live_url' => '', 'image' => '', 'featured' => false, 'created_at' => '2026-09-14 10:00:00', 'updated_at' => '2026-09-14 10:00:00'],
                ['id' => '5', 'title' => 'Code Snippet Vault', 'description' => 'Searchable developer snippet collection. This project demonstrates practical problem-solving, responsive design, and maintainable code.', 'short_description' => 'Store and find reusable coding solutions.', 'technologies' => 'JavaScript, PHP, Git', 'github_url' => 'https://github.com/your-username', 'live_url' => '', 'image' => '', 'featured' => false, 'created_at' => '2026-09-13 10:00:00', 'updated_at' => '2026-09-13 10:00:00'],
            ],
            'contacts' => [],
        ];
    }
}
