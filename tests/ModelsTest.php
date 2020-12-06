<?php

class ModelsTest extends Omeka_Test_TestCase
{
    public function testFoo()
    {
        $country = SuperEightFestivalsCountry::create([
            "location" => [
                "name" => "United States",
                "latitude" => 0.00,
                "longitude" => 0.00,
            ]
        ]);
        $this->assertNotEquals(null, $country);
        $this->assertNotEquals(0, $country->id);
    }
}
