<?php
/**
 * Created by PhpStorm.
 * User: YanTotal
 * Date: 20.07.15
 * Time: 14:00
 */
$numbers = array(1,3,4,7,1,6,2,3,1,1,9,4,2,3,4,8,7,1,1,1,4,9,8,0,5,1,2,"s","л","\\");
$groups = 12; #количество груп
//чистим массив
foreach($numbers as $key => $var) {
    if(!is_numeric($var))
        unset($numbers[$key]);
}
//сортируем по убыванию
arsort($numbers);
$numbers = array_values($numbers);
//считаемт кол-во столбцов
$count = ceil(count($numbers)/$groups);
if($count <= 2)
    die("Нужно меньше груп");

$s = 1;
for ($i = 1; $i <= $count; $i++) {
    if($i < $count) {
        if ($i % 2 == 0) {
            //заполняем столбец с конца, от большего к меньшему
            for ($e = $groups - 1; $e >= 0; $e--) {
                $array[$i][] = $numbers[$e];
                #удаляем использованные цифры и переиндексируем массив
                unset($numbers[$e]);
                $numbers = array_values($numbers);
            }
        } else {
            //заполняем столбец с начала, от большего к меньшему
            for ($g = 0; $g <= $groups - 1; $g++) {
                $array[$i][] = $numbers[$g];
                #удаляем использованные цифры и переиндексируем массив
                unset($numbers[$g]);
            }
        }
    }
    else { #последний столбец всегда заполняем снизу
        for ($l = $groups - 1; $l >= 0; $l--) {
            $array[$i][] = $numbers[$l];
            #удаляем использованные цифры и переиндексируем массив
            unset($numbers[$l]);
            $numbers = array_values($numbers);
        }
    }
    $numbers = array_values($numbers);
}

//выводим результат
$summ = 0;
for($i = 0; $i <= $groups-1; $i++) { #перебираем групы
    for($c = 1; $c <= $count; $c++) { #перебираем столбцы
        $summ = $summ + $array[$c][$i];
        if($c != $count) {
            echo $array[$c][$i];
            if(is_numeric($array[$c+1][$i]))
                echo ", ";
        }
        else {
            echo $array[$c][$i] . " = " . $summ;
        }
    }
    $summ = 0;
    echo '<br>';
}
