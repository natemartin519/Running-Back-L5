<?php namespace App\Repositories;

use App\Repositories\Interfaces\RunInterface;
use Illuminate\Support\Collection;

class FileRunRepository implements RunInterface {

    protected $gpsPoints;

    function __construct($fileName)
    {

        $file = File::get($fileName);

        // TODO: Check for null file

        $this->$gpsPoints = $this->loadPoints($file);
    }

    private function loadPoints(File $file)
    {
        $gpsPoints = new Collection();
        $xmlFormattedData = Formatter::make($file, Formatter::XML);
        $mapData = array_get($xmlFormattedData->toArray(), 'trk.trkseg.trkpt');

        foreach ($mapData as $lineData)
        {
            $lon = $lineData['@attributes']['lon'];
            $lat = $lineData['@attributes']['lat'];

            // TODO: New Point model
            $dataPoint = [
                'lon' => $lon,
                'lat' => $lat
            ];

            $this->gpsDataPoints->push($dataPoint);
        }

        return $gpsPoints;
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

    public function pointById($id)
    {
        return false;
    }
}