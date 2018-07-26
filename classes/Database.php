<?php

class Database
{
    // Настройки подключения к БД;
    private function setting() {
        try {
            $dsn = 'mysql:dbname=abz-tz;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
        }
        catch(PDOException $e) {
            echo 'Ошибка подключения: '. $e->getMessage();
        }
        return $dbh;
    }
    // Запись данных;
    // Метот принимает имя таблицы, массив с: фи, должность, дата приема, зарплата; и наличие/id босса, если таковой имеется;
    public function write_db($table, $a, $bos = null) {
        // Запрос для таблицы 1-го уровня, для владельца компании, у которого нет вышестоящего начальства;
        if ('owner' == $table) {
            $sql = "INSERT INTO `owner` (`id`, `initials`, `position`, `date`, `solary`) VALUES (NULL, :t2, :t3, :t4, :t5);";
            $dbh = $this->setting();
            $stm = $dbh->prepare($sql);
        } else {
            // Запрос для всех таблиц, где сотрудники имеют начальство;
            $sql = "INSERT INTO" . "`" . $table . "`" . "(`id`, `bos-id`, `initials`, `position`, `date`, `solary`) VALUES (NULL, :t1, :t2, :t3, :t4, :t5);";
            $dbh = $this->setting();
            $stm = $dbh->prepare($sql);
            $stm->bindValue(':t1', $bos, PDO::PARAM_INT);   // id начальника, необязательный параметр;
        }
        $stm->bindValue(':t2', $a[0], PDO::PARAM_STR);  // ФИО;
        $stm->bindValue(':t3', $a[1], PDO::PARAM_STR);  // Должность;
        $stm->bindValue(':t4', $a[2], PDO::PARAM_STR);  // Дата приема на работу;
        $stm->bindValue(':t5', $a[3], PDO::PARAM_INT);  // Заработная плата;
        $t = $stm->execute();
        // Метод возвращает номер последней записи;
        return $dbh->lastInsertId();;
    }

    /* Метот чтения одной записи для конкретного сотрудника по его id */
    public function read_one_id($table, $id) {
        /* Другой способ формирование строки запроса */
        $sql = "SELECT * FROM " . $table . " WHERE id='" . $id . "'";
        $dbh = $this->setting();
        $sth = $dbh->query($sql);
        /* чтобы не было дублей записей в массиве */
        return $sth->fetch(PDO::FETCH_NUM);
    }
    
    /* Метот чтения всех записей по id его босса */
    public function read_all_boss_id($table, $id_bos) {
        $sql = "SELECT * FROM `" . $table . "` WHERE `bos-id` = :t1";
        $dbh = $this->setting();
        $stm = $dbh->prepare($sql);
        $stm->bindValue(':t1', $id_bos, PDO::PARAM_INT);
        $stm->execute();
        /* Построчное извелчение результирующего набора */
        $result = [];
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }
}