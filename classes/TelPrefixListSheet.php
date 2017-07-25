<?php
/**
 * Parse Carrier Rate Tel Prefix List
 * To form
 * use Singleton
 */

class TelPrefixListSheet
{
    private static $instance = null;

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    // Name worksheet
    public CONST NAME = 'Tel Prefix List';

    public static function getInstance()
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function ParseTelPrefixListSheet(&$list)
    {
        $PrefixList = TelPrefixListTable::getInstance ();

        foreach ( $list as $key => $row )
        {
            $columnIter = 0;
            foreach ( $row as $col ) {
                // Reading the values after receiving all the headers
                if ($PrefixList->GetStart ())
                {
                    // ***
                    if ($PrefixList->FillTableByRow ($row) === true)
                    {
                        $PrefixList->getTableDate ();
                        return;
                    }
                    break;
                }

                if ($PrefixList->getFull () === false)
                {
                    for ($i = 0 ; $i < count ($PrefixList->RULE_FIELDS) ; $i++ )
                    {
                        if ( $PrefixList->RULE_FIELDS[ $i ][ 1 ] === false
                             && $col == $PrefixList->RULE_FIELDS[ $i ][ 0 ])
                        {
                            $PrefixList->setTrue ($i);
                            $PrefixList->RULE_FIELDS[$i][2] = $columnIter;
                        }
                    }
                }
                $columnIter++;
            }
        }
    }

}