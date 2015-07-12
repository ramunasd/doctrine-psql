<?php

namespace Psql\Doctrine\DBAL\Types;

use DateInterval as Interval;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * Interval type implemented as native DateInterval
 * 
 * @link http://www.postgresql.org/docs/devel/static/rangetypes.html
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class IntervalType extends Type
{
    const NAME = 'interval';

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
        return self::NAME;
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
        
        if (!$value instanceof Interval) {
            throw new \InvalidArgumentException('Interval value must be instance of DateInterval');
        }
        
        $parts = array(
            'y' => 'year',
            'm' => 'month',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        
        $sql = '';
        foreach ($parts as $key => $part) {
            $val = $value->{$key};
            if (empty($val)) {
                continue;
            }
            $sql .= " {$val} {$part}";
        }
        
        return trim($sql);
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
        preg_match(
            '/(?:(?P<y>[0-9]+) (?:year|years))?'
            . ' ?(?:(?P<m>[0-9]+) (?:months|month|mons|mon))?'
            . ' ?(?:(?P<d>[0-9]+) (?:days|day))?'
            . ' ?(?:(?P<h>[0-9]{2}):(?P<i>[0-9]{2}):(?P<s>[0-9]{2}))?/i',
            $value,
            $matches
        );
        
        if (empty($matches)) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
        
        $interval = new Interval('PT0S');
        
        if (!empty($matches['y'])) {
            $interval->y = $matches['y'];
        }
        
        if (!empty($matches['m'])) {
            $interval->m = $matches['m'];
        }
        
        if (!empty($matches['d'])) {
            $interval->d = $matches['d'];
        }
        
        if (!empty($matches['h'])) {
            $interval->h = $matches['h'];
        }
        
        if (!empty($matches['i'])) {
            $interval->i = $matches['i'];
        }
        
        if (!empty($matches['s'])) {
            $interval->s = $matches['s'];
        }
        
        return $interval;
    }
}
