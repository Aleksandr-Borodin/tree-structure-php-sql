<?php
session_start();
/* Автоподключение классов */
require_once __DIR__ . '/modules/bootstrap.php';

/* Подключение модели для работы с БД */
require_once __DIR__ . '/models/model.php';

/* Шапка сайта */
require_once __DIR__ . '/view/html/header.html';

/* 1-й уровень */
$m = $db->read_one_id('owner', '3');
/* Подключение view-контроллера для формирования 1 уровня иерархии*/
require __DIR__ . '/view/1-level.php';


/* 2-уровень */
if (!isset($_GET['level2'])) {
    $m = $db->read_all_boss_id('directors', $m[0]);
    require __DIR__ . '/view/2-level-multiple.php';

} else {
    /* Через сессии присваиваются выбранные айди с гета */
    if (isset($_GET['level2']) && !isset($_GET['level3'])) {
        $_SESSION['id2'] = $_GET['id'];
    }
    $m = $db->read_one_id('directors', $_SESSION['id2']);
    require __DIR__ . '/view/2-level-single.php';

    /* 3 уровень */
    if (!isset($_GET['level3'])) {
        $m = $db->read_all_boss_id('deputy', $_SESSION['id2']);
        require __DIR__ . '/view/3-level-multiple.php';
    } else {
        if (isset($_GET['level3']) && !isset($_GET['level4'])) {
            $_SESSION['id3'] = $_GET['id'];
        }
            $m = $db->read_one_id('deputy', $_SESSION['id3']);
            require __DIR__ . '/view/3-level-single.php';

            /* 4 уровень */
            if (!isset($_GET['level4'])) {
                $m = $db->read_all_boss_id('head', $_SESSION['id3']);
                require __DIR__ . '/view/4-level-multiple.php';
            } else {
                if (isset($_GET['level4'])) {
                    $_SESSION['id4'] = $_GET['id'];
                }
                    $m = $db->read_one_id('head', $_SESSION['id4']);
                    require __DIR__ . '/view/4-level-single.php';

                    /* 5 уровень */
                    $m = $db->read_all_boss_id('employees', $_SESSION['id4']);
                    require __DIR__ . '/view/5-level-multiple.php';
                }
            }
}
/* Подвал сайта */
require_once __DIR__ . '/view/html/footer.html';