<?php

/**
 * Created by PhpStorm.
 * User: Base
 * Date: 19.07.2017
 * Time: 14:34
 */
class Date
{
    public $Date;
    public $DateStr;
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
            //  July      05, 2017
            $temp = trim ($str,"\t\n\r\0\x0B");
            $temp = trim (preg_replace('/\s+/',' ', $temp));
            $temp = str_replace(',', '', $temp);
            $temp = explode(' ', $temp);
            $this->Day = $temp[1];
            $this->Month = Date::MONTH[$temp[0]];
            $this->Year = $temp[2];

            $this->Date = new DateTime();
            $this->Date->setDate($this->Year, $this->Month, $this->Day);
            $this->Date->setTime(0,0,0);
            $this->Date = date('d.m.Y H:i:s', date_timestamp_get($this->Date));

            // 05.07.2017 00:00:00
            $this->DateStr = $this->Day.'.'.$this->Month.'.'.$this->Year.' 00:00:00';

        } catch (Exception $exception){
            $this->Error = 'Somthing went wrong' . $exception->getMessage();
            user_error('Somthing went wrong', $exception);
        }
    }

    function __construct($str)
    {
        $Hour = 0;
        $this->initial($str);
    }


}