<?php

use App\Repositories\FileRunRepository as Run;
use App\Repositories\PointRepository as Point;
use Illuminate\Support\Facades\File;


class FileRunRepositoryTest extends TestCase {

    const FAKE_XML = '<gpx><trk><trkseg><trkpt lon="-80.0" lat="40.0"><ele>300.0</ele></trkpt><trkpt lon="-81.0" lat="41.0"><ele>301</ele></trkpt><trkpt lon="-82.0" lat="42.0"><ele>302.0</ele></trkpt><trkpt lon="-83.0" lat="43.0"><ele>303.0</ele></trkpt></trkseg></trk></gpx>';

    public function testRunReturnsCurrentPoint()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $firstPoint = new Point(40.0, -80.0, 300.0);

        $run = new Run('fake.gpx');

        $this->assertEquals($firstPoint, $run->currentPoint());
    }

    public function testRunReturnsPointByPosition()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $secondPoint = new Point(41.0, -81.0, 301.0);

        $run = new Run('fake.gpx');

        $this->assertEquals($secondPoint, $run->getPoint(2));
    }

    public function testRunReturnsCurrentPointAfterGetPoint()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $secondPoint = new Point(41.0, -81.0, 301.0);

        $run = new Run('fake.gpx');
        $run->getPoint(2);

        $this->assertEquals($secondPoint, $run->currentPoint());
    }

    public function testRunReturnsNextPoint()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $secondPoint = new Point(41.0, -81.0, 301.0);
        $thirdPoint = new Point(42.0, -82.0, 302.0);

        $run = new Run('fake.gpx');

        $this->assertEquals($secondPoint, $run->nextPoint());
        $this->assertEquals($thirdPoint, $run->nextPoint());
    }

    public function testRunReturnsCurrentPointAfterNextPointIsCalled()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $secondPoint = new Point(41.0, -81.0, 301.0);

        $run = new Run('fake.gpx');
        $run->nextPoint();

        $this->assertEquals($secondPoint, $run->currentPoint());
    }

    public function testRunReturnsPreviousPointPoint()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $firstPoint = new Point(40.0, -80.0, 300.0);
        $secondPoint = new Point(41.0, -81.0, 301.0);

        $run = new Run('fake.gpx');
        // Start from third point
        $run->getPoint(3);

        $this->assertEquals($secondPoint, $run->previousPoint());
        $this->assertEquals($firstPoint, $run->previousPoint());
    }

    public function testRunReturnsCurrentPointAfterPreviousPointIsCalled()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $firstPoint = new Point(40.0, -80.0, 300.0);

        $run = new Run('fake.gpx');
        // Start from second point
        $run->getPoint(2);
        $run->previousPoint();

        $this->assertEquals($firstPoint, $run->currentPoint());
    }

    public function testRunReturnsCollectionOfAllPoints()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);

        $run = new Run('fake.gpx');

        $this->assertInstanceOf('\Illuminate\Support\Collection', $run->allPoints());
        $this->assertCount(4, $run->allPoints());
    }

    public function testRunGoesToLastPointIfPreviousIsCalledFromFirstPoint()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $lastPoint = new Point(43.0, -83.0, 303.0);

        $run = new Run('fake.gpx');

        $this->assertEquals($lastPoint, $run->previousPoint());
    }

    public function testRunGoesToFirstPointIfNextIsCalledFromLastPoint()
    {
        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);
        $firstPoint = new Point(40.0, -80.0, 300.0);

        $run = new Run('fake.gpx');
        // Start from last point
        $run->getPoint(4);

        $this->assertEquals($firstPoint, $run->nextPoint());
    }

    public function testRunGetPointThrowsOutOfBoundsException()
    {
        $this->setExpectedException('OutOfBoundsException');

        File::shouldReceive('get')->once()->andReturn(self::FAKE_XML);

        $run = new Run('fake.gpx');
        $run->getPoint(7);
    }

    public function testRunThrowsFileNotFoundException()
    {
        $this->setExpectedException('\Illuminate\Contracts\Filesystem\FileNotFoundException');

        new Run('fake.gpx');
    }
}

