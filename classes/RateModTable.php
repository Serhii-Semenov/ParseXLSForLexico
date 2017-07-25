<?php
/**
 * For get table [ Description | Rate Per Minute | Period | Change ]
 * use Singleton
 */

class RateModTable
{
    private static $instance = null;
    private $Start;
    private $Full;

    public $Table;
    public $Error;
    public $RULE_FIELDS;

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
            1 => [ 0 => 'Features' , 1 => false, 2 => 0 ] ,
            2 => [ 0 => 'Rate Per Minute' ,  1 => false, 2 => 0 ] ,
            3 => [ 0 => 'Period' ,  1 => false, 2 => 0 ] ,
            4 => [ 0 => 'Change' ,  1 => false, 2 => 0 ]
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
        if ($row[$this->RULE_FIELDS[0][2]] == '')
        {
            $this->Start = false;
            return true;
        }

        // todo verification cell
        $error = false;
        $ratePerMinute = $row[$this->RULE_FIELDS[2][2]];
        $partsOfFloat = explode ('.', $ratePerMinute);
        if (count($partsOfFloat) == 2 && is_numeric ($partsOfFloat[0]) && is_numeric ($partsOfFloat[1]))
        {
            $ratePerMinute = number_format ((float)$ratePerMinute,  5 ,  '.', ' ' );
        }
        else
        {
            $error = true;
        }

        $destination = $this->toFormatDescription($row[$this->RULE_FIELDS[0][2]]);

        //
        // veryf float... is done

        $this->Table[] =
            [
                $destination,                           // [0] Description
                $row[$this->RULE_FIELDS[1][2]],         // [1] Features
                $ratePerMinute,                         // [2] Rate Per Minute
                $row[$this->RULE_FIELDS[3][2]],         // [3] Period
                $row[$this->RULE_FIELDS[4][2]],         // [4] Change
                $error                                  // [5] Error -> TRUE is exist
            ];
        return false;
    }

    public function getRateModRowByDestination($needle)
    {
        $a = 1;
        foreach ($this->Table as $row)
        {
            if ($row[0] === $needle)
            {
                return [
                    $row[0],    // destination
                    $row[2],    // Rate Per Minute
                    $row[3],    // Period
                    $row[4],    // Change
                    $row[5]     // Error
                ];
            }
        }
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