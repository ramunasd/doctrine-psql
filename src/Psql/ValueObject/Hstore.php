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
            return new self();
        }
        $values = json_decode('{' . str_replace('"=>"', '":"', $string) . '}', true);
        if (null === $values) {
            throw new \InvalidArgumentException('Cannot parse hstore representation');
        }
        $values = array_map(array(
            self,
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
            return new self();
        }
        $values = get_object_vars($object);
        if (null === $values) {
            throw new \InvalidArgumentException('Cannot get object values');
        }
        
        $values = array_map(array(
            self,
            'convertValue'
        ), $values);
        
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
        
        if ($value == 'true') {
            return true;
        }
        if ($value == 'false') {
            return false;
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
        
        foreach ($this as $key => $value) {
            if (!is_string($value) && !is_numeric($value) && !is_bool($value)) {
                throw new \InvalidArgumentException("Cannot save 'nested arrays' into hstore.");
            }
            $value = trim($value);
            if (!is_numeric($value) && false !== strpos($value, ' ')) {
                $value = sprintf('"%s"', $value);
            }
            $string .= "{$key} => {$value},";
        }
        return trim($string, ', ');
    }
}
