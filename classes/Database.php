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
}