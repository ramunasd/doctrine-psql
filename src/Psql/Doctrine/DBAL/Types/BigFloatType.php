<?php

namespace Psql\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Big float type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BigFloatType extends Type
{
    const NAME = 'bigfloat';

    /**
     * (non-PHPdoc)
     *
     * @see \Doctrine\DBAL\Types\Type::getName()
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Doctrine\DBAL\Types\Type::getSQLDeclaration()
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'float8';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Doctrine\DBAL\Types\Type::convertToPHPValue()
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : floatval($value);
    }
}
