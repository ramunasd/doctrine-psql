<?php

namespace Psql\Doctrine\DBAL\Types\Geometry;

use Psql\ValueObject\Geometry\Box;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\ConversionException;

/**
 * Box type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BoxType extends Type
{
    const NAME = 'box';

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
        return $platform->getDoctrineTypeMapping('BOX');
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
        
        if (is_array($value)) {
            $value = Box::fromArray($value);
        }
        
        if (!$value instanceof Box) {
            throw new \InvalidArgumentException(sprintf('Box value must be instance of Box'));
        }
        
        return sprintf('(%f, %f),(%f, %f)', $value->left, $value->bottom, $value->right, $value->top);
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
        
        $matches = array();
        if (!preg_match('`\((-?[0-9.]+),(-?[0-9.]+)\),\((-?[0-9.]+),(-?[0-9.]+)\)`', $value, $matches)) {
            throw ConversionException::conversionFailedFormat($value, self::NAME, '(x1,y1),(x2,y2)');
        }
        
        $box = new Box;
        $box->left = floatval($matches[1]);
        $box->bottom = floatval($matches[2]);
        $box->right = floatval($matches[3]);
        $box->top = floatval($matches[4]);
        
        return $box;
    }
}
