<?php
/**
 * Created by PhpStorm.
 * User: Base
 * Date: 21.07.2017
 * Time: 15:22
 */

class RoutePeriodTable
{
    private static $instance = null;
    private $Start;
    private $Full;

    public $Table;
    public $Error;
    public $RULE_FIELDS;

    public CONST MIXSTART = 0;
    public CONST MIXEND = 86399;
    public CONST MIXWEEK = 127;

    public static function getInstance ()
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone ()
    {
    }

    private function __construct ()
    {
        $this->init ();
    }

    private function init ()
    {
        $this->Start = false;
        $this->Full = false;

        // title | Found already | column
        $this->RULE_FIELDS = [
            0 => [ 0 => 'Description' ,  1 => false , 2 => 0] ,
            1 => [ 0 => 'Period' , 1 => false, 2 => 0 ],
            2 => [ 0 => 'Start Time' , 1 => false, 2 => 0 ],
            3 => [ 0 => 'End Time' , 1 => false, 2 => 0 ]
        ];
    }

    public function setTrue ( $iter )
    {
        $this->RULE_FIELDS[ $iter ][ 1 ] = true;
        $this->Full = $this->chekFull ();
    }

    private function chekFull ()
    {
        foreach ( $this->RULE_FIELDS as $row ) {
            if ( $row[ 1 ] === false ) return false;
        }
        $this->Start = true;
        return true;
    }

    public function GetStart()
    {
        return $this->Start;
    }

    public function getFull ()
    {
        return $this->Full;
    }

    public function FillTableByRow(&$row)
    {
        // todo verification cell
        if ($row[$this->RULE_FIELDS[0][2]] == '')
        {
            $this->Start = false;
            return true;
        }

        $this->Table[] =
            [
                $this->toFormatDescription($row[$this->RULE_FIELDS[0][2]]),
                $row[$this->RULE_FIELDS[1][2]],
                $row[$this->RULE_FIELDS[2][2]],
                $row[$this->RULE_FIELDS[3][2]]
            ];
        return false;
    }

    // Get a convenient ...
    // [0]Description [string(<40)]  | [1]Period [P, O, W] | [2]StarTime[second] | [3]EndTime[second] | [4]Week [bit] | [5]Err
    // bool($err) true Error is exist
    public function getTableDate()
    {
        $flagErr = true;
        $temp = array();
        foreach ($this->Table as $row)
        {
            $week = $this->getWeek($row[1]);
            $starttime = $this->getTime($row[2], $row[1], true);
            $endtime = $this->getTime($row[3], $row[1], false);
            $err = $week[1] || $starttime[1] || $endtime[1];
            if ($flagErr && $err)
            {
                $flagErr = false;
                $this->Error = true;
            }
            $temp[] = [
                $row[0],        // [0] Destination
                $row[1],        // [1] Period (M, P, O, W)
                $starttime[0],  // [2] Start Day Time
                $endtime[0],    // [3] End Day Time
                $week[0],       // [4] Week (bit)
                $err            // [5] Error -> True is exist
            ];
        }
        $this->Table = $temp;
    }

    public function GetPeriod($char, $dest)
    {
        if ($char ==='M')
        {
            return [
                RoutePeriodTable::MIXSTART,
                RoutePeriodTable::MIXEND,
                RoutePeriodTable::MIXWEEK,
                false
            ];
        }

        foreach ($this->Table as $row)
        {
            if ($row[0] === $dest && $row[1] === $char)
            {
                return [
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5]
                ];
            }
        }

        return [
            'Error',
            'Error',
            'Error',
            true
        ];

    }

    private function getWeek($c)
    {
        // M -> 127 -> 1111111
        $bit = 255;
        switch ($c)
        {
            case 'O':
                $bit = 31; // 11111
                break;
            case 'P':
                $bit = 31; // 11111
                break;
            case 'W':
                $bit = 96; // 1100000
                break;
            default :
                break;
                return [$c, true];
        }
        return [$bit, false];
    }

    private function getTime($time, $week, $start)
    {
        if ($week[1] === true)
        {
            return ['err', true];
        }

        switch ($week[0])
        {
            // todo verification
            case 'O':
            case 'P':
            case 'W':
                return $this->getParseTimeToSec($time, $start);
            default :
                return [$time, true];
                break;
        }
    }

    private function getParseTimeToSec($time, $start)
    {
        $time = trim ($time);
        $str = explode (' ', $time);
        if (count($str) == 1)
        {
            $str = $str[0];
        }
        elseif (count($str) == 2)
        {
            // TODO VERYFIC..PARSE DAY->WEEK
            $str = $str[1];
        }
            $str = explode (':', $str);
            if (count($str) == 3)
            {
                $h = $str[0];
                $m = $str[1];
                $s = $str[2];
                if (ctype_digit($h) && $h>=0 && $h<=23
                    && ctype_digit($m) && $m>=0 && $m<=59
                    && ctype_digit($s) && $s>=0 && $s<=59)
                {
                    $t = $h*60*60+$m*60+$s;
                    return [
                        (
                            $start ? ($t) : (($t)==0 ? 86399 : $t - 1)
                        ), (bool)false
                    ];
                }
            }
        return ['Error', (bool)true];
    }

    private function toFormatDescription($str)
    {
        $temp = trim($str);
        if (strlen($temp) >40)
        {
            $this->infoDestination[] = $temp;
            $temp = substr ($temp, 0, 40);
        }
        return $temp;
    }

}