<?php

namespace PsqlTest\Types;

use DateInterval;

/**
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class IntervalTypeTest extends AbstractTypeTest
{
    protected $typeName = 'interval';
    protected $typeClass = '\Psql\Doctrine\DBAL\Types\IntervalType';
    
    public function testDeclaration()
    {
        $this->assertEquals($this->typeName, $this->type->getName());
        $this->assertEquals('interval', $this->type->getSQLDeclaration(array(), $this->platform));
    }
    
    public function invalidPHPValueProvider()
    {
        return array(
            array(''),
            array(1),
            array(false),
            array(new \stdClass()),
        );
    }
    
    /**
     * @dataProvider invalidPHPValueProvider
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPHPValue($value)
    {
        $this->type->convertToDatabaseValue($value, $this->platform);
    }
    
    public function sqlValueProvider()
    {
        return array(
            array(null, null),
            array('1 year', new DateInterval('P1Y')),
            array('1 month', new DateInterval('P1M')),
            array('1 day', new DateInterval('P1D')),
            array('1 year 2 months 3 days', new DateInterval('P1Y2M3D')),
            array('2 months 1 day', new DateInterval('P2M1D')),
            array('2 days 04:05:06', new DateInterval('P2DT4H5M6S')),
            array('04:05:06', new DateInterval('PT4H5M6S')),
            array('1 year 2 months 3 days 04:05:06', new DateInterval('P1Y2M3DT4H5M6S')),
        );
    }
    
    public function phpValueProvider()
    {
        return array(
            array(null, null),
            array(new DateInterval('P1Y'), '1 year'),
            array(new DateInterval('PT1S'), '1 second'),
            array(new DateInterval('P1Y2D'), '1 year 2 day'),
            array(new DateInterval('PT1H2S'), '1 hour 2 second'),
            array(new DateInterval('PT0S'), ''),
        );
    }
}
