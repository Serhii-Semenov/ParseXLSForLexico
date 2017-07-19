<?php
/**
 * Created by PhpStorm.
 * User: Base
 * Date: 19.07.2017
 * Time: 14:15
 */
include_once ('classes/PHPExcel-1.8/Classes/PHPExcel.php');

spl_autoload_register(function ($class) {
    include_once 'classes/' . $class . '.php';
});

//$excel = (new PHPExcel_Reader_Excel5())->load('data/iBasisLight.xls', ReadDataOnly);
$excel = (new PHPExcel_Reader_Excel5())->load('data/iBasis.xls', ReadDataOnly);


$StartDateOfAction = StartDateOfAction::getInstance();

$flag = false;
foreach ($excel->getWorksheetIterator() as $worksheet){
    $lists[] = $worksheet->toArray();
    foreach ($lists as $list){
        if ($worksheet->getTitle() == 'Rate Mod Sheet') {
            foreach ($list as $key => $row){
                foreach ($row as $col){
                    // get row with required pattern and delete empty cell
                    if ($StartDateOfAction->getFull() == false)
                    for ($i = 0; $i < count($StartDateOfAction->RULE_SYMBOLS); $i++ ){
                        if ($StartDateOfAction->RULE_SYMBOLS[$i][2] == false
                            && $col == $StartDateOfAction->RULE_SYMBOLS[$i][0])
                        {
                            $StartDateOfAction->setTrue($i);
                            $StartDateOfAction->Change[] = array_diff($row, array('', NULL, false));
                        }
                    }
                }
            }
        }
    }
}

echo ($StartDateOfAction->getFull()).'<br>';
var_dump($StartDateOfAction->Change);
var_dump($StartDateOfAction->RULE_SYMBOLS);

unset($excel);