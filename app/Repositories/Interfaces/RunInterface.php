<?php namespace App\Repositories\Interfaces;


interface RunInterface {
    public function allPoints();
    public function nextPoint();
    public function previousPoint();
    public function pointById($id);
}