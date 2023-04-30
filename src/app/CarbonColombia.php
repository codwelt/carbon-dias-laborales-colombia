<?php

namespace Codwelt\CarbonColombia\App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CarbonColombia extends Carbon
{
    public $festivos = [];

    function calcularDomingoResurreccion($anio)
    {
        $a = $anio % 19;
        $b = floor($anio / 100);
        $c = $anio % 100;
        $d = floor($b / 4);
        $e = $b % 4;
        $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = floor($c / 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $mes = floor(($h + $l - 7 * $m + 114) / 31);
        $dia = (($h + $l - 7 * $m + 114) % 31) + 1;
        return Carbon::createFromDate($anio, $mes, $dia);
    }

    public function diasSemanaSanta()
    {
        $domingo_de_ramos = Carbon::createFromDate($this->year, 4, 1); //Dia domingo de ramos
        $primer_domingo_santo = $domingo_de_ramos->next(Carbon::SUNDAY);

        echo "<pre>";
        var_dump($primer_domingo_santo->format('Y-m-d'));
        var_dump($primer_domingo_santo->next(Carbon::THURSDAY)->format('Y-m-d'));
        exit();


        array_push($this->festivos, $primer_domingo->format('Y-m-d'));
    }

    public function diaDeLaAscencion()
    {
        $domingo_resurreccion = $this->calcularDomingoResurreccion($this->year);
        $ascension = $domingo_resurreccion->copy()->addDays(40);
        $primer_lunes = $ascension->next(Carbon::MONDAY);
        array_push($this->festivos, $primer_lunes->format('Y-m-d'));

    }

    public function diaDeLosReyesMagos()
    {
        $reyes = Carbon::createFromDate($this->year, 1, 6);
        $primer_lunes = $reyes->next(Carbon::MONDAY);
        array_push($this->festivos, $primer_lunes->format('Y-m-d'));
    }

    public function diaDeSanJose()
    {
        $jose = Carbon::createFromDate($this->year, 3, 19);
        $primer_lunes = $jose->next(Carbon::MONDAY);
        array_push($this->festivos, $primer_lunes->format('Y-m-d'));
    }

    public function diaDeCorpusChristi()
    {

    }


    public function calcularFeriadosAno()
    {

        array_push($this->festivos, $this->year . '-01-01'); // Año Nuevo
        $this->diaDeLosReyesMagos(); // Día de los Reyes Magos
        $this->diaDeSanJose(); // Día de San José
        $this->diasSemanaSanta(); //Domingo de Ramos


        $this->diaDeLaAscencion();
    }

    /**
     * @return int
     */
    public function diasLaboralesMes()
    {
        $this->calcularFeriadosAno();

        echo "Año: " . $this->year . "<br>";
        echo "Mes: " . $this->month . "<br>";

        // Crear un objeto Carbon para el primer día del mes
        $inicio_mes = Carbon::createFromDate($this->year, $this->month, 1);

        // Crear un objeto Carbon para el último día del mes
        $fin_mes = Carbon::createFromDate($this->year, $this->month, $inicio_mes->daysInMonth);

        // Generar un periodo de tiempo para cada día del mes
        $periodo = CarbonPeriod::create($inicio_mes, $fin_mes);

        // Definir los días de la semana que son días laborables (de lunes a viernes)
        $dias_laborables = [Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY];

        // Iterar sobre cada día del mes y verificar si es un día laborable
        $contador_dias_laborables = 0;
        foreach ($periodo as $dia) {
            // Verificar si el día es un día laborable
            if (in_array($dia->dayOfWeek, $dias_laborables) && !in_array($dia->format('Y-m-d'), $this->festivos)) {
                $contador_dias_laborables++;
            }
        }

        return $contador_dias_laborables;


    }

}