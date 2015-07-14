<?php

namespace PsqlTest\Types;

use Psql\ValueObject\Hstore;

/**
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class HstoreTypeTest extends AbstractTypeTest
{
    protected $typeName = 'hstore';
    protected $typeClass = '\Psql\Doctrine\DBAL\Types\HstoreType';
    
    public function testDeclaration()
    {
        $this->assertEquals($this->typeName, $this->type->getName());
        $this->assertEquals('hstore', $this->type->getSQLDeclaration(array(), $this->platform));
    }
    
    public function sqlValueProvider()
    {
        return array(
            array(null, null),
            array('', new Hstore),
            array('key => null', new Hstore(array('key' => null))),
            array('"1-a" => "anything at all"', new Hstore(array('1-a' => 'anything at all'))),
            array('"\"Title\"" => true', new Hstore(array('"Title"' => true))),
            array('"" => Title', new Hstore(array('' => 'Title'))),
            array('"" => "\"Title\""', new Hstore(array('' => '"Title"'))),
            array('a=>b, c=>d', new Hstore(array('a' => 'b', 'c' => 'd'))),
            array('"a"=>"b", c=>"d"', new Hstore(array('a' => 'b', 'c' => 'd'))),
            
        );
    }
    
    public function phpValueProvider()
    {
        return array(
            array(null, null),
            array(new Hstore, ''),
            array(new Hstore(array(1=>2.5, 3=>-4)), '1 => 2.5, 3 => -4'),
            array(new Hstore(array('key' => null)), '"key" => NULL'),
            array(new Hstore(array('1-a' => 'anything at all')), '"1-a" => "anything at all"'),
            array(new Hstore(array('' => '"Title"', '"Title"' => true)), '"" => "\"Title\"", "\"Title\"" => true'),
        );
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testNestedArrayConversion()
    {
        $this->type->convertToDatabaseValue(array(array()), $this->platform);
    }
}
