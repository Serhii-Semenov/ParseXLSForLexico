<?php
/**
 * Parse Rate Mod Sheet
 * To form
 * use Singleton
 */

class RateModSheet
{
    private static $instance = null;

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    // Name worksheet
    public CONST NAME = 'Rate Mod Sheet';

    public static function getInstance()
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function ParseRateModSheet(&$list)
    {
        $StartDateOfAction = StartDateOfActionTable::getInstance ();
        $RateMod = RateModTable::getInstance ();

        $flag = true; // flag for deleting headers

        foreach ( $list as $key => $row ) {
            $columnIter = 0;
            foreach ( $row as $col ) {
                // get row with required pattern and delete empty cell
                if ( $StartDateOfAction->getFull () === false )
                {
                    for ( $i = 0 ; $i < count ( $StartDateOfAction->RULE_SYMBOLS ) ; $i++ )
                    {
                        if ( $StartDateOfAction->RULE_SYMBOLS[ $i ][ 2 ] === false
                             && $col == $StartDateOfAction->RULE_SYMBOLS[ $i ][ 0 ] )
                        {
                            $StartDateOfAction->setTrue ( $i );
                            $StartDateOfAction->Change[] = array_diff ( $row , array ( '' , NULL , false ) );
                        }
                    }
                }

                // Reading the values after receiving all the headers
                if ($RateMod->GetStart ())
                {
                    if ($flag) { $flag = false; break; }
                    if ($RateMod->FillTableByRow ($row) === true)
                    {
                        $StartDateOfAction->getChangeDate ();
                        return;
                    }
                    break;
                }

                if ($RateMod->getFull () === false)
                {
                    for ($i = 0 ; $i < count ($RateMod->RULE_FIELDS) ; $i++ )
                    {
                        if ( $RateMod->RULE_FIELDS[ $i ][ 1 ] === false
                             && $col == $RateMod->RULE_FIELDS[ $i ][ 0 ])
                        {
                            $RateMod->setTrue ($i);
                            $RateMod->RULE_FIELDS[$i][2] = $columnIter;
                        }
                    }
                }
                $columnIter++;
            }
        }

    }

}