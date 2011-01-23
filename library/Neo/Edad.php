<?php
class Neo_Edad
{
    /*
     * Calcula la edad a partir de su fecha de nacimiento
     *
     * @param  date          $nacimiento Formato "2010-04-03"
     * return int
     */
    public static function edad($nacimiento)
    {
        list($anio,$mes,$dia) = explode("-",$nacimiento);
        $anio_dif = date("Y") - $anio;
        $mes_dif = date("m") - $mes;
        $dia_dif = date("d") - $dia;
        if ($dia_dif < 0 || $mes_dif < 0)
        $anio_dif--;
        return $anio_dif;
    }
}
