<?php

/**
 * Created by PhpStorm.
 * User: Base
 * Date: 19.07.2017
 * Time: 11:25
 */
class WorksheetExcel
{
    public $Error;

    // Worksheet in Excel file :
    public $RateModSheet;
    public $TelPrefixList;
    public $PendingRateList;
    public $RoutePeriodValues;

    // for search by Name worksheet
    public $PatternNameWorksheets = [
        0 => [ 0 => 'Rate Mod Sheet', 1 => false],
        1 => [ 0 => 'Tel Prefix List', 1 => false],
        2 => [ 0 => 'Pending Rate List', 1 => false],
        3 => [ 0 => 'Route Period Values', 1 => false]
    ];


    public function __construct($excel)
    {

         $this->initWorksheet($excel);
    }

    public function __clone() { }

    private function initWorksheet($excel){
        foreach ($excel->getWorksheetIterator() as $worksheet){
            $lists[] = $worksheet->toArray();
            foreach ($lists as $list){
                switch($worksheet->getTitle()){
                    case $this->PatternNameWorksheets[0][0]:{
                        if ($this->PatternNameWorksheets[0][1] == false) {
                            $this->PatternNameWorksheets[0][1] = true;
                            $this->PatternNameWorksheets[0][2] = $lists;
                        }
                        break;
                    }
                    case $this->PatternNameWorksheets[1][0]:{
                        if ($this->PatternNameWorksheets[1][1] == false) {
                            $this->PatternNameWorksheets[1][1] = true;
                            $this->PatternNameWorksheets[1][2] = $lists;
                        }
                        break;
                    }
                    case $this->PatternNameWorksheets[2][0]:{
                        if ($this->PatternNameWorksheets[2][1] == false) {
                            $this->PatternNameWorksheets[2][1] = true;
                            $this->PatternNameWorksheets[2][2] = $lists;
                        }
                        break;
                    }
                    case $this->PatternNameWorksheets[3][0]:{
                        if ($this->PatternNameWorksheets[3][1] == false) {
                            $this->PatternNameWorksheets[3][1] = true;
                            $this->PatternNameWorksheets[3][2] = $lists;
                        }
                        break;
                    }
                }

            }
        }
    }
}