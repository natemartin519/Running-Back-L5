<?php namespace App\Repositories\Interfaces;


interface PointInterface {
    public function fetchLatitude();
    public function fetchLongitude();
    public function fetchElevation();
}