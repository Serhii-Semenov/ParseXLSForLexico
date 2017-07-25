<?php
///**
// * temp
// */
//
//include_once ( dirname(__FILE__) . '/../classes/PHPExcel-1.8/Classes/PHPExcel.php' );
//
//spl_autoload_register (
//    function ( $class ) {
//        include_once dirname(__FILE__) .'/../classes/' . $class . '.php';
//    }
//);
//
//// bad idea:
//ini_set('memory_limit', '-1');
//
//$before = memory_get_usage ();
//$excel = ( new PHPExcel_Reader_Excel5() )->load ( dirname(__FILE__) . '/../data/iBasis.xls' );
//// iBasisLightErr
////$excel = ( new PHPExcel_Reader_Excel5() )->load ( 'data/iBasisLightErr.xls' );
//
//// $before[612 040]  --  $after[10 934 040]  --  diff[10 322 000]
////$excel = PHPExcel_IOFactory::load('data/iBasis.xls');
//// 611592  --  10933456  --  10321864
//
////$objectReader = PHPExcel_IOFactory::createReader('Excel5');
////$objectReader->setLoadSheetsOnly('Rate Mod Sheet');
////$objectReader->setReadDataOnly(true);
////$objectReader->
////$objPHPExcel = $objectReader->load("data/iBasis.xls");
//
//$after = memory_get_usage ();
//echo $before . '  --  ' . $after . '  --  ' . ( $after - $before ).'<hr>';
////exit();
//
//
//$StartDateOfAction = StartDateOfActionTable::getInstance ();
//$RateModSheet = RateModSheet::getInstance ();
//$RateMod = RateModTable::getInstance ();
//
////$flag = false;
//$j = 0;
//foreach ( $excel->getWorksheetIterator () as $worksheet ) {
//    $before = memory_get_usage();
//    $lists[] = $worksheet->toArray ();
//    // [0] 10949368  --  11564656  --  -615288~
//    // [1] 11569952  --  12117568  --  -547616~
//    // [2] 12117568  --  12120608  --  -3040~
//    // [3] 12120608  --  12130248  --  -9640~
//    $after = memory_get_usage();
//    echo "[$j] ".$before.'  --  '.$after.'  --  '.($before-$after).'<br>';
//}
//
//echo ( $StartDateOfAction->getFull () ) . '<br>';
//// var_dump ( $StartDateOfAction->Change );
////echo '<pre>';
////var_dump ($RateMod->RULE_FIELDS);
//////
////echo '</pre>';
////
////$c = count ($RateMod->Table);
////for ( $i = 0; $i<$c; $i++) {
////    echo $i;
////    var_dump ( $RateMod->Table[ $i ] );
////}
//
//
////echo ( $StartDateOfAction->getFull () ) . '<br>';
//// var_dump ( $StartDateOfAction->Change );
////foreach ($RoutePeriod->Table as $var )
////{
////    echo '<pre>';
////    var_dump ($var);
////    echo '</pre>';
////}
//
//
////$c = count ($RoutePeriod->Table);
////for ( $i = 0; $i<$c; $i++) {
////    echo $i;
////    var_dump ( $RoutePeriod->Table[ $i ] );
////}
//
//
//// *******************
////$temp = array ();
////for ($i = 1; $i <7 /*count ($PrefixList->Table)*/; $i++)
////{
////    $t1 = explode(',', $PrefixList->Table[$i][1]);
////    if (chekPrefix($t1)){
////        // TODO ...
////    }
////    foreach ($t1 as $v){
////        var_dump ($v);
////    }
////}
////
////function chekPrefix(&$t){
////    $e = true; // no error
////    for ($j = 0; $j < count ($t); $j ++){
////        $t[$j] = trim($t[$j]);
////        if (ctype_digit($t[$j]) && strlen ($t[$j]) < 40) $t[$j] = [$t[$j] => true];
////        else {
////            $t[$j] = [$t[$j] => false];
////            $e = false;
////        }
////    }
////    return $e;
////}
//// **********************
//
//unset( $excel );
//
//// ***********************
//function getPeriod($value){
//    global $StartDateOfAction;
//    $StartDateOfAction->callbackSearch = $value;
//    $resultBase = array_filter( $StartDateOfAction->Change, function( $innerArray, $val)
//    {
//        global $StartDateOfAction;
//        return in_array($StartDateOfAction->callbackSearch, $innerArray);
//    }, ARRAY_FILTER_USE_BOTH );
//}
//
////var_dump ($StartDateOfAction->Change);
////echo ($RoutePeriod->Error)?"yes"."<br>":"no"."<br>";
////var_dump ($RoutePeriod->Table);
//
//<?php
///**
// * index
// */
//
//
//// not realy good idea:>
//ini_set('memory_limit', '-1');
//
//spl_autoload_register (
//    function ( $class ) {
//        include_once dirname(__FILE__) . '/classes/' . $class . '.php';
//    }
//);
//
//// $e = new ResultCreator( dirname( __FILE__) . '/data/iBasis.xls');
// $e = new ResultCreator(dirname(__FILE__).'/data/iBasisLightErr.xls');
//// $e = new ResultCreator(dirname(__FILE__).'/data/iBasisLight.xls');
//
//if ($e->ErrorSheetsInFile)
//{
//    echo 'Sheets error!';
//    exit(1);
//}
//
//$e->PrintArrCoorect ();
//echo '<hr>';
//$e->PrintArrIncorrect ();
//
//exit();
//
//
//include_once ( dirname(__FILE__) . '/classes/PHPExcel-1.8/Classes/PHPExcel.php' );
//
//spl_autoload_register (
//    function ( $class ) {
//        include_once dirname(__FILE__) . '/classes/' . $class . '.php';
//    }
//);
//
//$excel = ( new PHPExcel_Reader_Excel5() )->load ( dirname(__FILE__).'/data/iBasis.xls' );
////$excel = ( new PHPExcel_Reader_Excel5() )->load ( 'data/iBasisLightErr.xls' );
//
//$StartDateOfAction = StartDateOfActionTable::getInstance ();
//
//$RateModSheet = RateModSheet::getInstance ();
//$RateMod = RateModTable::getInstance ();
//
//$PrefixListSheet = TelPrefixListSheet::getInstance ();
//$PrefixList = TelPrefixListTable::getInstance ();
//
//$RoutePeriodSheet = RoutePeriodSheet::getInstance ();
//$RoutePeriod = RoutePeriodTable::getInstance ();
//
//$lists = array (); // array Worksheets
//$nameSheetsList = array (); // array Names Worksheets
//$nameSheetsIter = 0; // Iterator by name
//foreach ( $excel->getWorksheetIterator () as $worksheet )
//{
//    $lists[] = $worksheet->toArray ();
//    $nameSheetsList[] = $worksheet->getTitle ();
//}
//foreach ( $lists as $list )
//{
//    switch ( $nameSheetsList[$nameSheetsIter ++] )
//    {
//        case RateModSheet::NAME :
//            $RateModSheet->ParseRateModSheet ($list);
//            break;
//        case TelPrefixListSheet::NAME :
//            $PrefixListSheet->ParseTelPrefixListSheet($list);
//            break;
//        case RoutePeriodSheet::NAME :
//            $RoutePeriodSheet->ParseRoutePeriodSheet ($list);
//            break;
//        default:
//            break;
//    }
//}
//unset( $excel );
//
//// ***************************
//
////$c = count ($PrefixList->Table);
////for ( $i = 0; $i<$c; $i++) {
////    echo $i;
////    foreach ( $PrefixList->Table[ $i ] as $var)
////        var_dump ($var);
////}
//
//////for ($i = 0; $i<10; $i++)
////var_dump ($PrefixList->Table[$i]);
////$Result = array ();
//
//
//
//$RateMod->Table;
//
//$count = count($RoutePeriod->Table);
//
//$kkk = 0;
//
//echo ($RoutePeriod->Error)?"yes"."<br>":"no"."<br>";
//var_dump ($RoutePeriod->Table);
//
//echo '<hr>';
//
//for ($i = 0; $i<$count; $i++)
//{
//    if ($kkk++ > 5) break;
//
//    // $needle -> Destination
//    $needle = $PrefixList->Table[$i][0];
//
//    // getRateModTable
//    $resultBase = array_filter( $RateMod->Table, function( $innerArray){
//        global $needle;
//        return in_array($needle, $innerArray);    //Поиск по всему массиву
//        //return ($innerArray[0] == $needle); //Поиск по первому значению
//    });
//
//    // Period -> ($CHAR['M,P,O,W'], dest)
//    $p = $RoutePeriod->GetPeriod (
//        $resultBase[ array_keys( $resultBase)[ 0]] [ 3],
//        $needle
//    );
//
//    $temp = [
//        $PrefixList->Table[$i][1] ,                         // [0] prefix
//        $PrefixList->Table[$i][0] ,                         // [1] destination
//        $resultBase[ array_keys( $resultBase)[ 0]] [ 2] ,   // [2] price
//        getChangeDate(
//            $resultBase[ array_keys( $resultBase)[ 0]] [ 4],
//            $StartDateOfAction->Change
//        ),                                                  // [3] stardDate
//        $p[0],                                              // [4] StartDayTime
//        $p[1],                                              // [5] EndDayTime
//        $p[2]                                               // [6] Week
//    ];
//
//    foreach ($temp as $value){
//        echo  $value.';';
//    }
//    echo '<hr>';
//}
//
//function getChangeDate($search, $arr){
//    foreach ($arr as $row)
//    {
//        foreach ($row as $key => $value)
//        {
//            if ($key === $search) return $value;
//        }
//    }
//    return 'Error: cant find any period';
//}


// Find errors
//if ($prefixErr || $baseRoeError || $periodErr || $startDateError)
//{
//    $this->Error = true;
//    $tableName = 'ArrIncorrect';
//}
//else
//{
//    $tableName = 'ArrCoorect';
//}
//
//$temp = [
//    $prefix,            // [0] prefix
//    $destination,       // [1] destination
//    $resultBase[ 1 ],   // [2] price
//    $stardDate[ 0 ],    // [3] stardDate
//    $period[ 0 ],       // [4] StartDayTime
//    $period[ 1 ],       // [5] EndDayTime
//    $period[ 2 ]        // [6] Week
//];
//array_push($this->$$tableName, $temp);