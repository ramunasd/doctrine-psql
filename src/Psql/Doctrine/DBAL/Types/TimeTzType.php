<?php

namespace Psql\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * Time type with timezone
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class TimeTzType extends Type
{
    const NAME = 'timetz';
    const FORMAT = 'H:i:sO';

    /**
     * (non-PHPdoc)
     * @see \Doctrine\DBAL\Types\Type::getName()
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * (non-PHPdoc)
     * @see \Doctrine\DBAL\Types\Type::getSQLDeclaration()
     */
    public function getSQLDeclaration (array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'TIME(0) WITH TIME ZONE';
    }

    /**
     * (non-PHPdoc)
     * @see \Doctrine\DBAL\Types\Type::convertToDatabaseValue()
     */
    public function convertToDatabaseValue ($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        
        return $value->format(self::FORMAT);
    }

    /**
     * (non-PHPdoc)
     * @see \Doctrine\DBAL\Types\Type::convertToPHPValue()
     */
    public function convertToPHPValue ($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        
        $val = \DateTime::createFromFormat('!' . self::FORMAT, $value);
        
        if (empty($val)) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), self::FORMAT);
        }
        
        return $val;
    }
}
