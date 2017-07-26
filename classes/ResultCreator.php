<?php
/**
 * Result Class
 */
include_once ( dirname(__FILE__) . '/../classes/PHPExcel-1.8/Classes/PHPExcel.php' );
spl_autoload_register (
    function ( $class ) {
        include_once dirname(__FILE__) . '/../classes/' . $class . '.php';
    }
);

class ResultCreator
{
    public $Excel;
    public $StartDateOfAction;
    public $RateModSheet;
    public $RateMod;
    public $PrefixListSheet;
    public $PrefixList;
    public $RoutePeriodSheet;
    public $RoutePeriod;

    public $ArrCorrect;
    public $ArrIncorrect;

    public $ErrorSheetsInFile = false;
    public CONST ERR = 'Invalid or corrupted file';
    public $Error = false;
    public $LoadComplite = false;

    public function __construct($fileName)
    {
        $this->initSingletones();
        $this->init($fileName);
    }

    public function PrintArrCoorect()
    {
        if (!is_null ($this->ArrCorrect))$this->printBigTable ( $this->ArrCorrect);
    }

    public function PrintArrIncorrect()
    {
        if (!is_null ($this->ArrIncorrect)) $this->printBigTable ($this->ArrIncorrect);
    }

    private function initSingletones()
    {
        $this->StartDateOfAction = StartDateOfActionTable::getInstance ();
        $this->RateModSheet = RateModSheet::getInstance ();
        $this->RateMod = RateModTable::getInstance ();
        $this->PrefixListSheet = TelPrefixListSheet::getInstance ();
        $this->PrefixList = TelPrefixListTable::getInstance ();
        $this->RoutePeriodSheet = RoutePeriodSheet::getInstance ();
        $this->RoutePeriod = RoutePeriodTable::getInstance ();
    }

    private function init($fileName)
    {
        try
        {
            $this->Excel = ( new PHPExcel_Reader_Excel5() )->load ( $fileName );
        }
        catch (Exception  $er)
        {
            $this->ErrorSheetsInFile = true;
            echo ResultCreator::ERR . '<br>';
            user_error('Somthing went wrong', $er->getMessage ());
        }
        $this->loadTables();
        $this->getResult();
    }

    private function loadTables()
    {
        $flag1 = false;
        $flag2 = false;
        $flag3 = false;

        $lists = array ();          // array Worksheets
        $nameSheetsList = array (); // array Names Worksheets
        $nameSheetsIter = 0;        // Iterator by name
        foreach ( $this->Excel->getWorksheetIterator () as $worksheet )
        {
            $lists[] = $worksheet->toArray ();
            $nameSheetsList[] = $worksheet->getTitle ();
        }
        foreach ( $lists as $list )
        {
            switch ( trim($nameSheetsList[$nameSheetsIter ++]) )
            {
                case RateModSheet::NAME :
                    $this->RateModSheet->ParseRateModSheet ($list);
                    $flag1 = true;
                    break;
                case TelPrefixListSheet::NAME :
                    $this->PrefixListSheet->ParseTelPrefixListSheet($list);
                    $flag2 = true;
                    break;
                case RoutePeriodSheet::NAME :
                    $this->RoutePeriodSheet->ParseRoutePeriodSheet ($list);
                    $flag3 = true;
                    break;
                default:
                    break;
            }
        }
        if ($flag1 && $flag2 && $flag3)
            unset( $this->Excel );
        else
        {
            $this->ErrorSheetsInFile = true;
            echo ResultCreator::ERR . '<br>';
        }
    }

    private function getResult()
    {
        $needleDestination = '';
        $period = '';
        $periodTempChar = '';
        $stardDate = '';
        $stardDateTempChar ='';
        $flagDestinationForPeriod = true;
        $resultBase = array ();

        $count = count($this->PrefixList->Table);
        for ($i = 0; $i<$count; $i++)
        {
            // getPrefix
            $prefix = $this->PrefixList->Table[ $i ][ 1 ];
            $prefixErr = $this->PrefixList->Table[ $i ][ 2 ];

            // getDestination
            $destination = $this->PrefixList->Table[ $i ][ 0 ];

            // $needle -> Destination
            // IF ... -> To speed up the search process
            if ($needleDestination !== $destination)
            {
                $needleDestination = $destination;
                // Change flag becouse Destination was changed
                $flagDestinationForPeriod = true;
                // [0]destination | [1]Rate Per Minute | [2]Period | [3]Change
                $resultBase = $this->RateMod->getRateModRowByDestination($needleDestination);
                $baseRoeError = $resultBase[4];
                // why error is true?
                //
            }

            // Period -> ($CHAR['M,P,O,W'], dest)
            // IF ... -> To speed up the search process
            if ($periodTempChar !== $resultBase[ 2 ] || $flagDestinationForPeriod )
            {
                $period = $this->RoutePeriod->GetPeriod ($resultBase[ 2 ] , $needleDestination);
                $periodTempChar = $resultBase[ 2 ];
                $flagDestinationForPeriod = false;
                $periodErr = $period[3];
            }

            // Start Date -> U,I,D,T,N,C
            // IF ... -> To speed up the search process
            if ($stardDateTempChar !== $resultBase[ 3 ] )
            {
                $stardDate = $this->StartDateOfAction->getDateByParam($resultBase[ 3 ]);
                $stardDateTempChar = $resultBase[ 3 ];
                $startDateError = $stardDate[1];
            }

            // Find errors
            if ($prefixErr || $baseRoeError || $periodErr || $startDateError)
            {
                $this->Error = true;
                $this->ArrIncorrect[] = [
                    $prefix,            // [0] prefix
                    $destination,       // [1] destination
                    $resultBase[ 1 ],   // [2] price
                    $stardDate[ 0 ],    // [3] stardDate
                    $period[ 0 ],       // [4] StartDayTime
                    $period[ 1 ],       // [5] EndDayTime
                    $period[ 2 ]        // [6] Week
                ];
            }
            else
            {
                $this->ArrCorrect[] = [
                    $prefix,            // [0] prefix
                    $destination,       // [1] destination
                    $resultBase[ 1 ],   // [2] price
                    $stardDate[ 0 ],    // [3] stardDate
                    $period[ 0 ],       // [4] StartDayTime
                    $period[ 1 ],       // [5] EndDayTime
                    $period[ 2 ]        // [6] Week
                ];
            }
        }
        $this->LoadComplite = true;
    }

    private function printByRow($row)
    {
        foreach ($row as $value )
        {
            echo $value . ';';
        }
        echo '<br>';
    }

    private function printBigTable($tbl)
    {
        foreach ($tbl as $row)
        {
            $this->printByRow($row);
        }
    }



}