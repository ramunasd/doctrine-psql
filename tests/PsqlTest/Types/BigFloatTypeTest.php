<?php

namespace PsqlTest\Types;

use Doctrine\DBAL\Types\Type;

/**
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BigFloatTypeTest extends AbstractTypeTest
{
    protected $typeName = 'bigfloat';
    protected $typeClass = '\Psql\Doctrine\DBAL\Types\BigFloatType';
    
    public function testDeclaration()
    {
        $this->assertEquals($this->typeName, $this->type->getName());
        $this->assertEquals('float8', $this->type->getSQLDeclaration(array(), $this->platform));
    }
    
    public function sqlValueProvider()
    {
        return array(
            array(null, null),
            array('1', 1),
            array('0', 0),
            array('.1', .1),
            array('-0.3', round(.3, 1) * -1),
            array(strval(PHP_INT_MAX), PHP_INT_MAX),
            array('-' . PHP_INT_MAX, -1 * PHP_INT_MAX),
        );
    }
    
    public function phpValueProvider()
    {
        return array(
            array(null, null),
            array(0, '0'),
            array(1, '1'),
            array(-1, '-1'),
            array(.1, '0.1'),
            array(.3, '0.3'),
            array(PHP_INT_MAX, strval(PHP_INT_MAX)),
            array(PHP_INT_MAX * -1, '-' . strval(PHP_INT_MAX)),
        );
    }
}
