<?php
// Простой автозагрузчик классов;
class Load
{
    public function loadclass($a)
    {
        $b = __DIR__ . '//' . $a . '.php';
        if (!file_exists($b)) {
            echo 'нет такого класса! ' . "<br>" . $a . "<br>" . 'По адресу: ' . "<br>" . $b;
            exit;
        }
        require_once $b;
    }
}