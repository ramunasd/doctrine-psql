<?php

namespace Psql\ValueObject;

/**
 * Hstore object
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Hstore extends \ArrayObject
{
    /**
     * Create hstore from string
     *
     * @param string $string            
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function fromString($string)
    {
        if (empty($string)) {
            return new self;
        }
        $string = ',' . $string . ',';
        $string = preg_replace('/\s*=>\s*/', ':', trim($string));
        $string = preg_replace('/\,\s*["]?([^:\"]+)["]?\:/', ',"$1":', $string);
        $string = preg_replace('/:["]?([^\"]+)["]?\s*,/', ':"$1",', $string);
        $string = trim($string, ', ');
        $values = json_decode('{' . $string . '}', true);
        if (null === $values) {
            throw new \InvalidArgumentException('Cannot parse hstore representation');
        }
        $values = array_map(array(
            __CLASS__,
            'convertValue'
        ), $values);
        
        return new self($values);
    }

    /**
     * Create hstore from object
     *
     * @param object $object            
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function fromObject($object)
    {
        if (empty($object)) {
            return new self;
        }
        $values = get_object_vars($object);
        if (null === $values) {
            return new self;
        }
        
        return new self($values);
    }

    /**
     * Convert hstore value to PHP value
     *
     * @param string $value
     * @return string|int|float|bool
     */
    public static function convertValue($value)
    {
        if (is_numeric($value)) {
            if (false === strpos($value, '.')) {
                return intval($value);
            } else {
                return floatval($value);
            }
        }
        
        if (!strcasecmp($value, 'true')) {
            return true;
        }
        if (!strcasecmp($value, 'false')) {
            return false;
        }
        if (!strcasecmp($value, 'null')) {
            return null;
        }
        
        return $value;
    }
    
    /**
     * Hstore representation in PostgreSQL format
     * 
     * @return string
     */
    public function __toString()
    {
        if ($this->count() == 0) {
            return '';
        }
        
        $string = '';
        
        foreach ($this->getArrayCopy() as $key => $value) {
            $key = $this->escape($key);
            if ($value === null) {
                $string .= "{$key} => NULL, ";
                continue;
            }
            
            switch(gettype($value)) {
                case 'boolean':
                    $value = $value ? 'true' : 'false';
                    break;
                case 'integer':
                case 'floatval':
                case 'double':
                    break;
                case 'string':
                    $value = $this->escape($value);
                    break;
                default:
                    echo gettype($value);
                    throw new \InvalidArgumentException('Cannot save non scalar values into hstore.');
            }

            $string .= "{$key} => {$value}, ";
        }
        
        return trim($string, ', ');
    }
    
    /**
     * @param string $string
     * @return string
     */
    protected function escape($string)
    {
        if (empty($string)) {
            return '""';
        }
        if (!is_integer($string)) {
            $string = sprintf('"%s"', str_replace('"', '\"', $string));
        }
        return $string;
    }
}
