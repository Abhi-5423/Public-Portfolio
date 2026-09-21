<?php namespace App\Repositories;

use App\Config\Env;
use App\Database\{FileConnection, MongoConnection, MySQLConnection};
use App\Repositories\File\{FileAdminRepository, FileContactRepository, FileProjectRepository, FileSkillRepository};
use App\Repositories\MongoDB\{MongoAdminRepository, MongoContactRepository, MongoProjectRepository, MongoSkillRepository};
use App\Repositories\MySQL\{MySQLAdminRepository, MySQLContactRepository, MySQLProjectRepository, MySQLSkillRepository};

final class RepositoryFactory
{
    private object $db;

    public function __construct()
    {
        $driver = Env::get('DB_DRIVER', 'file');
        $this->db = match ($driver) {
            'mysql' => new MySQLConnection(),
            'mongodb' => new MongoConnection(),
            default => new FileConnection(ROOT.'/storage/database.json'),
        };
    }

    public function projects()
    {
        return match ($this->db->driver()) {
            'mysql' => new MySQLProjectRepository($this->db),
            'mongodb' => new MongoProjectRepository($this->db),
            default => new FileProjectRepository($this->db),
        };
    }

    public function skills()
    {
        return match ($this->db->driver()) {
            'mysql' => new MySQLSkillRepository($this->db),
            'mongodb' => new MongoSkillRepository($this->db),
            default => new FileSkillRepository($this->db),
        };
    }

    public function contacts()
    {
        return match ($this->db->driver()) {
            'mysql' => new MySQLContactRepository($this->db),
            'mongodb' => new MongoContactRepository($this->db),
            default => new FileContactRepository($this->db),
        };
    }

    public function admins()
    {
        return match ($this->db->driver()) {
            'mysql' => new MySQLAdminRepository($this->db),
            'mongodb' => new MongoAdminRepository($this->db),
            default => new FileAdminRepository($this->db),
        };
    }
}
