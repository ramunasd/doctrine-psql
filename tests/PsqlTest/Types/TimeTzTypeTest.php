<?php

namespace PsqlTest\Types;

use DateTime;
use DateTimeZone;

/**
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class TimeTzTypeTest extends AbstractTypeTest
{
    protected $typeName = 'timetz';
    protected $typeClass = 'Psql\Doctrine\DBAL\Types\TimeTzType';
    
    public function testDeclaration()
    {
        $this->assertEquals($this->typeName, $this->type->getName());
        $this->assertEquals(
            'TIME(0) WITH TIME ZONE',
            $this->type->getSQLDeclaration(array(), $this->platform)
        );
    }
    
    public function sqlValueProvider()
    {
        $values = array(
            array(null, null),
            array('00:00:00+00', new DateTime('@0')),
            array('01:00:00+00', new DateTime('@3600')),
            array('01:00:00+01', new DateTime('1970-01-01T01:00:00+01')),
            array('12:00:00+03', new DateTime('1970-01-01T12:00:00GMT+3')),
        );
        
        return $values;
    }
    
    public function phpValueProvider()
    {
        return array(
            array(null, null),
            array(new DateTime('@0'), '00:00:00+0000'),
            array(new DateTime('@3600'), '01:00:00+0000'),
        );
    }
}
