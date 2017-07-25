<?php
/**
 * For get table [ Description | Prefix List [] ]
 * use Singleton
 */

class TelPrefixListTable
{
    private static $instance = null;
    private $Start;
    private $Full;

    public $Table;
    public $Error;
    public $infoDestinationMoreThen40; // is exist Destination strlen > 40
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
        $this->Error = false;

        // title | Found already | column
        $this->RULE_FIELDS = [
            0 => [ 0 => 'Description' ,  1 => false , 2 => 0] ,
            1 => [ 0 => 'Prefix List' , 1 => false, 2 => 0 ]
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
        // todo

        $this->Table[] =
            [
                $row[$this->RULE_FIELDS[0][2]],
                trim($row[$this->RULE_FIELDS[1][2]])
            ];
        return false;
    }

    // Get a convenient ...
    public function getTableDate()
    {
        $tempTable = array ();
        $tempPrefixArray = array ();
        for ($i = 1; $i < count ($this->Table); $i++)
        {
            $prefArr = explode(',', $this->Table[$i][1]);
            // chek Prefix
            if ($this->checkPrefix($prefArr) === false) $this->Error = true;

            foreach ($prefArr as $val){
                // ROW = [Description | Prefix |  Bool(if true then NO Error ~is not exist~)]
                // To Format Description
                $descr = $this->toFormatDescription ($this->Table[$i][0]);
                $temp[] = [$descr, (int)$val[0], (bool)$val[1]];
            }
        }
        $this->Table = $temp;
    }

    // To Format Description
    // Destination - строка, длина 40 символов (обрезать до 40 символов)
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

    // Prefix - строка, только цифры, длина 40 символов
    private function checkPrefix(&$t)
    {
        $e = false; // no error
        for ($j = 0; $j < count ($t); $j ++){
            $t[$j] = trim($t[$j]);
            if (ctype_digit($t[$j]) && strlen ($t[$j]) <= 40) $t[$j] = [(int)$t[$j] , false];
            else {
                $t[$j] = [(int)$t[$j] , true];
                $e = true;
            }
        }
        return $e;
    }
}
































