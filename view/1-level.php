<?php
/* Вывод таблицы для владельца компании */
/* Шапка таблицы */
$initials = $m[2];
$position = $m[1];
$date = $m[3];
$solary = $m[4];
require __DIR__ . '/html/1h-level.html';
require __DIR__ . '/html/header-table.html';
/* Тело таблицы */
require __DIR__ . '/html/single-body-table.html';
/* Футер таблицы */
require __DIR__ . '/html/footer-table.html';