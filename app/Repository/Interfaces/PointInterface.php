<?php namespace App\Repositories\Interfaces;


interface PointInterface {
    public function latitude();
    public function longitude();
    public function elevation();
}