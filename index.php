<?php
/**
 * index
 */

// not realy good idea:>
ini_set('memory_limit', '-1');

spl_autoload_register (
    function ( $class ) {
        include_once dirname(__FILE__) . '/classes/' . $class . '.php';
    }
);

// За получение двух массивов с правильными и неправильными данными отвечает class ResultCreator;
// путь к файлу передаем в конструктор

 $e = new ResultCreator( dirname( __FILE__) . '/data/iBasis.xls');
// $e = new ResultCreator(dirname(__FILE__).'/data/iBasisLightErr.xls');
// $e = new ResultCreator(dirname(__FILE__).'/data/iBasisLight.xls');
// $e = new ResultCreator(dirname(__FILE__).'/data/Book1.xls');
// $e = new ResultCreator(dirname(__FILE__).'/data/Book2.xls');

// выдаст ошибку на несопадение с именами по рабочим листам
if ($e->ErrorSheetsInFile)
{
    echo 'Sheets error!';
    exit(1);
}

// ждем загрузки и окончания маппинга файла в массивы
// while (!$e->LoadComplite)
//     sleep (3);

// в случае невалидности выдаст сообщение
if ($e->Error) echo '<p style="color: red"><b>Файд "невалидный"</b></p>';

// сначала распечатаем валидный массив
$e->PrintArrCoorect ();
echo '<hr>';

// рапечатыем НЕвалидный массив, если таковой существует
$e->PrintArrIncorrect ();

exit();


