<?php

use App\Repositories\PointRepository;

class FilePointRepositoryTest extends TestCase {

    protected $point;

    public function setUp()
    {
        parent::setUp();
        $this->point = new PointRepository(50, 10, 5);
    }

    public function testShouldReturnLatitudeOfFifty()
    {
        $this->assertEquals(50, $this->point->latitude());
    }

    public function testShouldReturnLongitudeOfTen()
    {
        $this->assertEquals(10, $this->point->longitude());
    }

    public function testShouldReturnElevationOfFive()
    {
        $this->assertEquals(5, $this->point->elevation());
    }
}
