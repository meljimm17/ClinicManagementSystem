<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$config = config('database.connections.mysql');
echo "CONFIG:\n";
echo 'host=' . ($config['host'] ?? 'NULL') . PHP_EOL;
echo 'port=' . ($config['port'] ?? 'NULL') . PHP_EOL;
echo 'database=' . ($config['database'] ?? 'NULL') . PHP_EOL;
echo 'username=' . ($config['username'] ?? 'NULL') . PHP_EOL;
echo 'password=' . ($config['password'] ? 'SET' : 'EMPTY') . PHP_EOL;
echo 'driver=' . ($config['driver'] ?? 'NULL') . PHP_EOL;

try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $config['host'], $config['port'], $config['database'], $config['charset']);
    $pdo = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "PDO OK\n";
    $stmt = $pdo->query('select database()');
    echo 'connected_db=' . $stmt->fetchColumn() . PHP_EOL;
} catch (PDOException $e) {
    echo "PDO ERROR: " . $e->getMessage() . PHP_EOL;
}
