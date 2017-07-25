<?php

/**
 * For get Table [Action | Date]
 * use Singleton
 */
class StartDateOfActionTable
{
    private static $instance = null;
    private $Full;

    public $Change;
    public $RULE_SYMBOLS;

    public $callbackSearch;

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
        $this->Full = false;
        $this->RULE_SYMBOLS = [
            0 => [ 0 => 'Rate Mod Date:' , 1 => 'U' , 2 => false ] ,
            1 => [ 0 => 'Increases Effective:' , 1 => 'I' , 2 => false ] ,
            2 => [ 0 => 'Decreases Effective:' , 1 => 'D' , 2 => false ] ,
            3 => [ 0 => 'Terminations Effective:' , 1 => 'T' , 2 => false ] ,
            4 => [ 0 => 'New Rates Effective:' , 1 => 'N' , 2 => false ] ,
            5 => [ 0 => 'Code Change Effective:' , 1 => 'C' , 2 => false ]
        ];
    }

    public function setTrue ( $iter )
    {
        $this->RULE_SYMBOLS[ $iter ][ 2 ] = true;
        $this->Full = $this->chekFull ();
    }

    private function chekFull ()
    {
        foreach ( $this->RULE_SYMBOLS as $row ) {
            if ( $row[ 2 ] == false ) return false;
        }
        return true;
    }

    public function getFull ()
    {
        return $this->Full;
    }

    // Get a convenient key => value table
    public function getChangeDate()
    {
        foreach ($this->Change as $row)
        {
            foreach ($this->RULE_SYMBOLS as $rule)
            {
                if (reset ($row) == $rule[0])
                {
                    $data = new DateCreator( next( $row));
                    // char(U,I,D,T,N,C) | date | error
                    $temp[] = [$rule[1], $data->Date, $data->Error];
                    unset($data);
                }
            }
        }
        $this->Change = $temp;
    }

    public function getDateByParam($search){
        foreach ($this->Change as $row)
        {
            if ($row[0] === $search) return [$row[1], $row[2]];
        }
        return ['Error: couldn`t find the period', true];
    }

}