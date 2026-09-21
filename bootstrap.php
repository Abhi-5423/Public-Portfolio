<?php declare(strict_types=1);

define('ROOT', __DIR__);

$autoload = ROOT.'/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
} else {
    spl_autoload_register(static function (string $class): void {
        $prefix = 'App\\';
        if (!str_starts_with($class, $prefix)) {
            return;
        }

        $file = ROOT.'/app/'.str_replace('\\', '/', substr($class, strlen($prefix))).'.php';
        if (is_file($file)) {
            require $file;
        }
    });
}

\App\Config\Env::load(ROOT);
$development = \App\Config\Env::get('APP_ENV', 'production') === 'development';
ini_set('display_errors', $development ? '1' : '0');
error_reporting($development ? E_ALL : 0);
$sessionPath = ROOT.'/storage/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0775, true);
}
session_save_path($sessionPath);
session_name(\App\Config\Env::get('SESSION_NAME', 'student_portfolio_session'));
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')]);
session_start();

require ROOT.'/app/Helpers/helpers.php';

$factory = new \App\Repositories\RepositoryFactory();
$service = new \App\Services\PortfolioService($factory);
