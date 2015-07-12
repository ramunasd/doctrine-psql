<?php

namespace PsqlTest\Types;

use Doctrine\DBAL\Types\Type;

/**
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
abstract class AbstractTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $typeName = '';
    
    /**
     * @var string
     */
    protected $typeClass = '';
    
    /**
     * @var Type
     */
    protected $type;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $platform;
    
    protected function setUp()
    {
        if (!Type::hasType($this->typeName)) {
            Type::addType($this->typeName, $this->typeClass);
        }
        $this->type = Type::getType($this->typeName);
        $this->platform = $this->getMock('Doctrine\DBAL\Platforms\AbstractPlatform');
    }
    
    /**
     * @dataProvider sqlValueProvider
     */
    public function testConversionToPHP($sql, $expected)
    {
        $value = $this->type->convertToPHPValue($sql, $this->platform);
        $this->assertEquals($expected, $value);
    }
    
    /**
     * @dataProvider phpValueProvider
     */
    public function testConversionToSQL($value, $expected)
    {
        $sql = $this->type->convertToDatabaseValue($value, $this->platform);
        $this->assertEquals($expected, $sql);
    }
}
