<?php
/**
 * Created by PhpStorm.
 * User: ramunas
 * Date: 15.7.21
 * Time: 22.01
 */

namespace PsqlTest\Types\Arrays;

use PsqlTest\Types\AbstractTypeTest;
use Doctrine\DBAL\Types\Type;

class BigFloatArrayTypeTest extends AbstractTypeTest
{
    protected $typeName = 'bigfloat[]';
    protected $typeClass = '\Psql\Doctrine\DBAL\Types\Arrays\BigFloatArrayType';

    protected function setUp()
    {
        parent::setUp();
        if (!Type::hasType('bigfloat')) {
            Type::addType('bigfloat', '\Psql\Doctrine\DBAL\Types\BigFloatType');
        }
    }

    public function sqlValueProvider()
    {
        return array(
            array('{}', array()),
            array('{1}', array(1)),
            array('{1.2, 3}', array(1.2, 3)),
            array('{{1}, {2}}', array(array(1), array(2))),
            array('{{1.2, 3}, {4}}', array(array(1.2, 3), array(4))),
            array('{12000000000000000}', array(1.2e16)),
        );
    }

    public function phpValueProvider()
    {
        return array(
            array(array(), '{}'),
            array(array(1), '{1}'),
            array(array(1.2, 3), '{1.2, 3}'),
            array(array(array(1), array(2)), '{{1}, {2}}'),
            array(array(array(1.2, 3), array(4)), '{{1.2, 3}, {4}}'),
            array(array(1.2e16), '{1.2E+16}'),
        );
    }
}