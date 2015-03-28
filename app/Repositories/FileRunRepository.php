<?php namespace App\Repositories;

use App\Repositories\Interfaces\RunInterface;
use App\Repositories\PointRepository as Point;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use OutOfBoundsException;
use SoapBox\Formatter\Formatter;

class FileRunRepository implements RunInterface {

    protected $pointCollection;
    protected $position;

    function __construct($fileName)
    {
        $file = File::get($fileName);

        $this->pointCollection = $this->loadPoints($file);
        $this->position = 0;
    }

    private function loadPoints($file)
    {
        $pointCollection = new Collection();

        $xmlFormattedData = Formatter::make($file, Formatter::XML);
        $mapData = array_get($xmlFormattedData->toArray(), 'trk.trkseg.trkpt');

        foreach ($mapData as $lineData)
        {
            $lon = $lineData['@attributes']['lon'];
            $lat = $lineData['@attributes']['lat'];
            $ele = $lineData['ele'];

            $pointCollection->push(new Point($lat, $lon, $ele));
        }

        return $pointCollection;
    }

    public function allPoints()
    {
        return $this->pointCollection;
    }

    public function nextPoint()
    {
        $this->position = ($this->position == $this->allPoints()->count() - 1) ? 0 : $this->position + 1;
        return $this->currentPoint();
    }

    public function getPoint($id)
    {
        $this->position = $id - 1;
        $point = $this->currentPoint();

        if (is_null($point)) throw new OutOfBoundsException('{$id} was not found in collection', $id);

        return $point;
    }

    public function previousPoint()
    {
        $this->position = ($this->position == 0) ? $this->allPoints()->count() - 1 : $this->position - 1;
        return $this->currentPoint();
    }

    public function currentPoint()
    {
        return $this->pointCollection->get($this->position);
    }
}