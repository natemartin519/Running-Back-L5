<?php namespace App\Repositories\Interfaces;


interface RunInterface {
    public function fetchAllPoints();
    public function fetchPointById($id);
}