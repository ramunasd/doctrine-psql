<?php

namespace PsqlTest\ValueObject\Geometry;

use Psql\ValueObject\Geometry\Box;

class BoxTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidDataProvider
     */
    public function testCreationFromInvalidArray($data)
    {
        Box::fromArray($data);
    }

    public function invalidDataProvider()
    {
        return array(
            array(array()),
            array(array(1)),
            array(array(1, 2, 3)),
            array(array(1, 2, 3, 4, 5)),
        );
    }

    public function testCreationFromAssociatedArray()
    {
        $box = Box::fromArray(array(1, "2.3", null, 9.99));
        $this->assertEquals(1, $box->left);
        $this->assertEquals(2.3, $box->bottom);
        $this->assertEquals(0, $box->right);
        $this->assertEquals(9.99, $box->top);
    }

    public function testCreationFromCoordinateArray()
    {
        $box = Box::fromArray(array(
            'x1' => 1,
            'y1' => '2.3',
            'x2' => null,
            'y2' => 9.99,
        ));
        $this->assertEquals(1, $box->left);
        $this->assertEquals(2.3, $box->bottom);
        $this->assertEquals(0, $box->right);
        $this->assertEquals(9.99, $box->top);
    }
}