<?php

/**
 * Created by PhpStorm.
 * User: Base
 * Date: 19.07.2017
 * Time: 14:34
 */
class  DateCreator
{
    // initial year for veryfication
    public CONST YEARMIN = 1999;
    public CONST YEARMAX = 2020;

    public $Date;
    public $DateStr;
    public $ErrorMessage;
    public $Error;
    public $Day;
    public $Month;
    public $Year;

    public CONST MONTH = array(
        'January' => '01',
        'February' => '02',
        'March' => '03',
        'April'=> '04',
        'May'=> '05',
        'June' => '06',
        'July' => '07',
        'August' => '08',
        'September' => '09',
        'October' => '10',
        'November' => '11',
        'December' => '12'
    );

    private function initial($str){
        try{
            // FORMAT :
            //  July      05, 2017
            $temp = trim ($str,"\t\n\r\0\x0B");
            $temp = trim (preg_replace('/\s+/',' ', $temp));
            $temp = str_replace(',', '', $temp);
            $temp = explode(' ', $temp);

            if ( $this->CheckYear ($temp[2])) $this->Year = $temp[2];
            if ( $this->CheckMonth ( DateCreator::MONTH[ $temp[ 0]])) $this->Month = DateCreator::MONTH[ $temp[ 0]];
            if ( $this->CheckDay ($temp[1])) $this->Day = $temp[1];

            // is chek for Error
            if ( !is_null ($this->ErrorMessage) )
            {
                $this->Error = true;
                $this->ErrorMessage = chop(trim($this->ErrorMessage),',');
                $this->Date = $this->ErrorMessage;
                return;
            }

            $this->Date = new DateTime();
            $this->Date->setDate($this->Year, $this->Month, $this->Day);
            $this->Date->setTime(0,0,0);
            $this->Date = date('d.m.Y H:i:s', date_timestamp_get($this->Date));

            // TO FORM :
            // 05.07.2017 00:00:00
            // $this->DateStr = $this->Day.'.'.$this->Month.'.'.$this->Year.' 00:00:00';

        } catch (Exception $exception){
            $this->ErrorMessage = 'Somthing went wrong' . $exception->getMessage();
            $this->Date = 'Incorrect date';
            $this->Error = true;
            //user_error('Somthing went wrong', $exception);
        }
    }

    function __construct($str)
    {
        $this->initial($str);
    }

    private function CheckYear($year)
    {
        if ( DateCreator::YEARMIN < $year && $year < DateCreator::YEARMAX) return true;
        $this->ErrorMessage = $this->ErrorMessage .' Wrong YEAR,';
        return false;
    }

    private function CheckMonth($month)
    {
        if (0 < $month && $month <= 12) return true;
        $this->ErrorMessage = $this->ErrorMessage .' Wrong MONTH,';
        return false;
    }

    private function CheckDay($Day)
    {
        $y = is_null ($this->Year) ? date('Y') : $this->Year;
        if (checkdate($this->Month, $Day, $y)) return true;
        $this->ErrorMessage = $this->ErrorMessage .' Wrong Day,';
        return false;
    }

}