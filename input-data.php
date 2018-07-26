<?php
/* Автоподключение классов */
require_once __DIR__ . '/modules/bootstrap.php';

/* Создаем обьект класса для работы с БД */
$db = new Database();

/* Получим данные для конкретного человека, за их генерирование отвечает класс Datatext */
$dt = new Datatext('owner');
/* Возвращает массив с соответствующими индексами */
$m = $dt->givet();
/* Запишем владельца компании - он один) */
$id_bos = $db->write_db('owner', array($m['position'], $m['name'] . ' ' . $m['surname'], $m['date'], $m['solary']));

/* Вывод процеса добавления - для наглядности */
$sch = 1;
echo $sch . "<br>";

/* Через цикл запишем все записи в БД */
for ($n2 = 1; $n2 <= 10; $n2++) {
    /* Запишем директоров компании - их 10 */
    $dt = new Datatext('directors');
    $m = $dt->givet();
    $id_bos2 = $db->write_db('directors', array($m['position'], $m['name'] . ' ' . $m['surname'], $m['date'], $m['solary']), $id_bos);
    echo $sch++ . "<br>";
    for ($n3 = 1; $n3 <= 10; $n3++) {
        /* Запишем заместителей директоров компании - их по 10 */
        $dt = new Datatext('deputy');
        $m = $dt->givet();
        $id_bos3 = $db->write_db('deputy', array($m['position'], $m['name'] . ' ' . $m['surname'], $m['date'], $m['solary']), $id_bos2);
        echo $sch++ . "<br>";
        for ($n4 = 1; $n4 <= 10; $n4++) {
            /* Запишем глав отделов - их по 10 */
            $dt = new Datatext('head');
            $m = $dt->givet();
            $id_bos4 = $db->write_db('head', array($m['position'], $m['name'] . ' ' . $m['surname'], $m['date'], $m['solary']), $id_bos3);
            echo $sch++ . "<br>";
            for ($n5 = 1; $n5 <= 50; $n5++) {
                /* Запишем работников компании - их по 50 */
                $dt = new Datatext('employees');
                $m = $dt->givet();
                $db->write_db('employees', array($m['position'], $m['name'] . ' ' . $m['surname'], $m['date'], $m['solary']), $id_bos4);
                echo $sch++ . "<br>";
            }
        }
    }
}