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

// $e = new ResultCreator( dirname( __FILE__) . '/data/iBasis.xls');
 $e = new ResultCreator(dirname(__FILE__).'/data/iBasisLightErr.xls');
// $e = new ResultCreator(dirname(__FILE__).'/data/iBasisLight.xls');

if ($e->ErrorSheetsInFile)
{
    echo 'Sheets error!';
    exit(1);
}

while (!$e->LoadComplite)
    sleep (3);

if ($e->Error) echo '<p style="color: red"><b>Файд "невалидный"</b></p>';

$e->PrintArrCoorect ();
echo '<hr>';
$e->PrintArrIncorrect ();

exit();


