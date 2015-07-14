<?php

namespace Psql\ValueObject\Geometry;

/**
 * Box object
 *  
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Box
{
    public $left = 0;
    public $bottom = 0;
    public $right = 0;
    public $top = 0;
    
    /**
     * @param array $value
     * @return self
     */
    public static function fromArray(array $value)
    {
        if (!count($value) == 4) {
            throw new \InvalidArgumentException('Box array must be from 4 elements');
        }
        
        if (reset($value) === null) {
            return null;
        }
        
        $box = new self;
        
        if (!empty($value['x1'])) {
            $box->left = floatval($array['x1']);
            $box->bottom = floatval($array['y1']);
            $box->right = floatval($array['x2']);
            $box->top = floatval($array['y2']);
        } elseif (!empty($value[0])) {
            $box->left = floatval($array[0]);
            $box->bottom = floatval($array[1]);
            $box->right = floatval($array[2]);
            $box->top = floatval($array[3]);
        }
        
        return $box;
    }
}
