<?php

namespace Psql\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * Timestamp type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class DateTimeType extends Type
{
    const NAME = 'timestamp';
    const FORMAT = 'Y-m-d H:i:s.u';

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
        return 'timestamp';
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \Doctrine\DBAL\Types\Type::convertToDatabaseValue()
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        if ($value instanceof \DateTime) {
            return $value->format(self::FORMAT);
        }
        if (is_string($value)) {
            try {
                $dt = new \DateTime($value);
                return $dt->format(self::FORMAT);
            } catch (\Exception $e) {
                throw new \Exception('Date "' . $value . '" is not a valid date');
            }
        }
        
        throw new \Exception('Date "' . $value . '" is not a valid date');
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Doctrine\DBAL\Types\Type::convertToPHPValue()
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        
        $val = \DateTime::createFromFormat(self::FORMAT, $value);
        if (! $val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), self::FORMAT);
        }
        
        return $val;
    }
}
