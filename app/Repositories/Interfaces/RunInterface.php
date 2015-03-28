<?php namespace App\Repositories\Interfaces;


interface RunInterface {
    public function currentPoint();
    public function allPoints();
    public function nextPoint();
    public function previousPoint();
}