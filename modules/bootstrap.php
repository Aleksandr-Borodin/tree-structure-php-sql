<?php
// Автозагрузка классво через ооп;
$tpath = dirname(__DIR__);
$path = $tpath . '/classes/Load.php';
require_once $path;
$loader = new Load();
spl_autoload_register([$loader, 'loadclass']);