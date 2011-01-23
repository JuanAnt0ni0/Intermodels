<?php

class Neo_ConvertUnid
{
    const IN = 'in';
    const FT = 'ft';
    const LB = 'lb';

    static $_unid = array(
        self::IN => 0.393700787,
        self::FT => 0.032808399,
        self::LB => 2.20462262
    );
    
    public static function convertCmTo($cm, $unid, $decimal = 2)
    {
        $value = $cm * (double)self::getFactor($unid);
        $auxi  = self::decimal($decimal);
        return round($value * $auxi) / $auxi;
    }

    public static function convertKgToLb($kg)
    {
        $value = $kg * (double)self::getFactor('lb');
        $auxi  = self::decimal(2);
        return round($value * $auxi) / $auxi;
    }


    protected static function getFactor($unid)
    {
        return self::$_unid[$unid];
    }
		
    protected static function decimal($decimal)
    {
        $value = 1;

        for ($i=1; $i<= $decimal; $i++){
                $value = $value * 10;
        }

        return $value;
    }
		
}