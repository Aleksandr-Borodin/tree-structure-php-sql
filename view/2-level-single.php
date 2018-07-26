<?php
$initials = $m[3];
$position = $m[2];
$date = $m[4];
$solary = $m[5];
require __DIR__ . '/html/2h-level.html';
require __DIR__ . '/html/header-table.html';
/* Тело таблицы */
require __DIR__ . '/html/single-body-table.html';
/* Футер таблицы */
require __DIR__ . '/html/footer-table.html';