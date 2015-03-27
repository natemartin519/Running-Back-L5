<?php namespace App\Repositories;

use App\Repositories\Interfaces\PointInterface;

class PointRepository implements PointInterface {

    protected $latitude;
    protected $longitude;
    protected $elevation;

    function __construct($latitude, $longitude, $elevation)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->elevation = $elevation;
    }

    public function latitude()
    {
        return $this->latitude;
    }

    public function longitude()
    {
        return $this->longitude;
    }

    public function elevation()
    {
        return $this->elevation;
    }
}