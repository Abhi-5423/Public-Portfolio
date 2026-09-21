<?php
// Local development router: php -S localhost:8000 router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$root = __DIR__;

// Redirect /admin or /admin/ to dashboard
if ($path === '/admin' || $path === '/admin/') {
    header('Location: /admin/dashboard.php');
    exit;
}

// Serve admin files
if (str_starts_with($path, '/admin/')) {
    $file = $root . $path;
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/index.php';
    }
    if (is_file($file)) {
        require $file;
        return;
    }
}

// Serve public static assets with correct MIME types
if (str_starts_with($path, '/uploads/') || str_starts_with($path, '/assets/')) {
    $file = $root . '/public' . $path;
    if (is_file($file)) {
        $mimes = [
            'css'   => 'text/css; charset=UTF-8',
            'js'    => 'text/javascript; charset=UTF-8',
            'json'  => 'application/json; charset=UTF-8',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'webp'  => 'image/webp',
            'svg'   => 'image/svg+xml',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'pdf'   => 'application/pdf',
        ];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        header('Content-Type: ' . ($mimes[$ext] ?? 'application/octet-stream'));
        readfile($file);
        return;
    }
}

// Serve public PHP pages
$file = $root . '/public' . ($path === '/' ? '/index.php' : $path);
if (is_dir($file)) {
    $file = rtrim($file, '/') . '/index.php';
}
if (is_file($file)) {
    require $file;
    return;
}

// Support extension-less URLs (e.g. /projects -> /public/projects.php)
if (is_file($file . '.php')) {
    require $file . '.php';
    return;
}

http_response_code(404);
echo 'Not found';

