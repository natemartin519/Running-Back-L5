<?php namespace App\Repositories;

use App\Repositories\Interfaces\RunInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class FileRunRepository implements RunInterface {

    protected $pointsCollection;

    function __construct($fileName = null)
    {
        $file = File::get($fileName);

        // TODO: Check for null file

        $this->pointsCollection = $this->loadPoints($file);
    }

    private function loadPoints($file)
    {
        $points = new Collection();

// TODO: Re-implement once tests are in place
//        $xmlFormattedData = Formatter::make($file, Formatter::XML);
//        $mapData = array_get($xmlFormattedData->toArray(), 'trk.trkseg.trkpt');
//
//        foreach ($mapData as $lineData)
//        {
//            $lon = $lineData['@attributes']['lon'];
//            $lat = $lineData['@attributes']['lat'];
//
//            // TODO: New Point model
//            $dataPoint = [
//                'lon' => $lon,
//                'lat' => $lat
//            ];
//
//            $this->gpsDataPoints->push($dataPoint);
//        }

        return $points;
    }

    public function allPoints()
    {
        return false;
    }

    public function nextPoint()
    {
        return false;
    }

    public function previousPoint()
    {
        return false;
    }

    public function currentPoint()
    {
        return false;
    }
}