<?php
/* Класс генерации данных сотрудника, отправить нужно только его должность */
class Datatext
{
  private $m = [];  // Массив всех имен и фамилий;
  private $d = [];  // Конечный массив с данными;
  /* Считаем данные с файлов в массив */
  private function rt($a) {
    if ('name' == $a) {
      $p1 = __DIR__ . '\..\modules\name.txt';
    } else {
      $p1 = __DIR__ . '\..\modules\surname.txt';
    }
    $t = file_get_contents($p1);
    return explode(', ', $t);
  }
  /* Присвоим полученные данные свойству */
  private function appr() {
    $this->m[0] = $this->rt('name');
    $this->m[1] = $this->rt('surname');
  }
  /* Выберем рандомное значение */
  private function rd() {
    $this->appr();
    $this->d['name'] = $this->m[0][rand(0, count($this->m[0])-1)];
    $this->d['surname'] = $this->m[1][rand(0, count($this->m[1])-1)];
  }
  /* Присвоение должности и зарплаты в зависимости от уровня */
  private function install_level ($l) {
    switch ($l) {
      case 'owner':
        $this->d['position'] = 'владелец компании';
        $this->d['solary'] = 100000;
        break;
      case 'directors':
        $this->d['position'] = 'директор';
        $this->d['solary'] = 80000;
        break;
      case 'deputy':
        $this->d['position'] = 'помощник директора';
        $this->d['solary'] = 60000;
        break;
      case 'head':
        $this->d['position'] = 'глава отдела';
        $this->d['solary'] = 40000;
        break;
      default:
        $this->d['position'] = 'рядовой сотрудник';
        $this->d['solary'] = 20000;
        break;
    }
  }
  /* Присвоение даты приема */
  private function date_receipt() {
    $month = rand(1, 12);
    If ($month < 10) {
      $month = '0' . $month;
    }
    If ('02' == $month) {
      $days_limit = 28;
    } else if ('11' == $month || '9' == $month || '6' == $month || '4' == $month) {
      $days_limit = 30;
    } else {
      $days_limit = 31;
    }
    $day = rand(1, $days_limit);
    If ($day < 10) {
      $day = '0' . $day;
    }
    $this->d['date'] = rand(1960, 2018) . '-' . $month . '-' . $day;

  }
  /* Финальная функция сбора всех данных */
  public function __construct($level) {
    /* Присвоение свойству даты приема */
    $this->date_receipt();
    /* Присвоение должности и зарплаты */
    $this->install_level($level);
    /* Генерация имени и фамилии */
    $this->rd();
  }
  /* Возвращение массива с данными */
  public function givet() {
    return $this->d;
  }  
}