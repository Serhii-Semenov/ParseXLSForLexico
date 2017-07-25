<?php
/**
 * Created by PhpStorm.
 * User: Base
 * Date: 21.07.2017
 * Time: 15:22
 */

class RoutePeriodSheet
{
    private static $instance = null;

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    // Name worksheet
    public CONST NAME = 'Route Period Values';

    public static function getInstance()
    {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function ParseRoutePeriodSheet(&$list)
    {
        $RoutePeriod = RoutePeriodTable::getInstance ();

        foreach ( $list as $key => $row ) {
            $columnIter = 0;
            foreach ( $row as $col ) {
                // Reading the values after receiving all the headers
                if ($RoutePeriod->GetStart ())
                {
                    // ***
                    if ($RoutePeriod->FillTableByRow ($row) === true)
                    {
                        $RoutePeriod->getTableDate ();
                        return;
                    }
                    break;
                }

                if ($RoutePeriod->getFull () === false)
                {
                    for ($i = 0 ; $i < count ($RoutePeriod->RULE_FIELDS) ; $i++ )
                    {
                        if ( $RoutePeriod->RULE_FIELDS[ $i ][ 1 ] === false
                             && $col === $RoutePeriod->RULE_FIELDS[ $i ][ 0 ])
                        {
                            $RoutePeriod->setTrue ($i);
                            if ($i === 1)
                            {
                                $a = $i;
                            }
                            $RoutePeriod->RULE_FIELDS[$i][2] = $columnIter;
                        }
                    }
                }
                $columnIter ++;
            }
        }
    }
}