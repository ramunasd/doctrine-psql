<?php

namespace Psql\Doctrine\DBAL\Types;

use Psql\ValueObject\Hstore;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\ConversionException;

/**
 * Postgresql hstore type
 * 
 * @link http://www.postgresql.org/docs/devel/static/hstore.html
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class HstoreType extends Type
{
    const NAME = 'hstore';

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
        return 'hstore';
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return array
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        
        if (empty($value)) {
            return new Hstore;
        }
        
        try {
            $store = Hstore::fromString($value);
        } catch (\Exception $e) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
        
        return $store;
    }

    /**
     * @param array|stdClass $value
     * @param AbstractPlatform $platform
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return '';
        }
        
        if ($value instanceof \stdClass) {
            $value = Hstore::fromObject($value);
        }
        if (is_string($value)) {
            $value = Hstore::fromString($value);
        }
        if (!$value instanceof Hstore) {
            throw new \InvalidArgumentException("Hstore value must be off array or \stdClass.");
        }

        return $value->__toString();
    }
}
