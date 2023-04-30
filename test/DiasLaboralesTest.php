<?php

use Codwelt\CarbonColombia\app\CarbonColombia;

class DiasLaboralesTest extends \PHPUnit\Framework\TestCase
{

    public function testDiasLaboralesMes()
    {
        $dias = CarbonColombia::now();
        $this->assertEquals(18, $dias->diasLaboralesMes());
    }
}