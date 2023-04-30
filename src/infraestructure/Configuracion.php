<?php

namespace Codwelt\CarbonColombia\Infraestructure;

class Configuracion
{
    // Definir días festivos de Colombia para el año 2023

    public function __construct()
    {
        // Definir la zona horaria
        date_default_timezone_set('America/Bogota');
    }

}