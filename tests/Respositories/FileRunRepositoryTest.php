<?php

use App\Repositories\FileRunRepository as Run;
use Illuminate\Support\Facades\File;


class FileRunRepositoryTest extends TestCase {

    protected $run;

    public function setUp()
    {
        parent::setUp();
        File::shouldReceive('get')->once()->andReturn('fakefile');
        $this->run = new Run('fakefile');
    }

    public function testRunReturnsCurrentPoint()
    {
        $this->assertEquals($this->pointOne, $this->run->currentPoint());
    }

    public function testRunReturnsNextPoint()
    {
        $this->assertEquals($this->pointTwo, $this->run->nextPoint());
        $this->assertEquals($this->pointThree, $this->run->nextPoint());
    }

    public function testRunReturnsPreviousPointPoint()
    {
        $this->assertEquals($this->pointThree, $this->run->previousPoint());
        $this->assertEquals($this->pointTwo, $this->run->previousPoint());
    }

    public function testRunReturnsCollectionOfAllPoints()
    {
        $this->fail();
    }

    public function testThrowExceptionIfFileNotFound()
    {
        $this->fail();
    }
}
