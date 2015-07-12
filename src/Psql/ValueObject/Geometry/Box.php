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
     * @param array $array
     * @return self
     */
    public static function fromArray(array $array)
    {
        if (!count($array) == 4) {
            throw new \InvalidArgumentException('Box array must be from 4 elements');
        }
        
        if (reset($array) === null) {
            return null;
        }
        
        $box = new self;
        
        if (isset($value['x1'])) {
            $box->left = $array['x1'];
            $box->bottom = $array['y1'];
            $box->right = $array['x2'];
            $box->top = $array['y2'];
        } elseif (isset($value[0])) {
            $box->left = $array[0];
            $box->bottom = $array[1];
            $box->right = $array[2];
            $box->top = $array[3];
        }
        
        return $box;
    }
}
