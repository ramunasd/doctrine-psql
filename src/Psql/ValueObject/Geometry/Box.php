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
            $box->left = floatval($value['x1']);
            $box->bottom = floatval($value['y1']);
            $box->right = floatval($value['x2']);
            $box->top = floatval($value['y2']);
        } elseif (!empty($value[0])) {
            $box->left = floatval($value[0]);
            $box->bottom = floatval($value[1]);
            $box->right = floatval($value[2]);
            $box->top = floatval($value[3]);
        }
        
        return $box;
    }
}
