<?php
// Автозагрузка классво через ооп;
$path = __DIR__ . '\load.php';
require_once $path;
$loader = new Load();
spl_autoload_register([$loader, 'loadclass']);
