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
    /** @var float */
    public $left = 0;

    /** @var float */
    public $bottom = 0;

    /** @var float */
    public $right = 0;

    /** @var float */
    public $top = 0;

    /**
     * @param float $left
     * @param float $bottom
     * @param float $right
     * @param float $top
     */
    public function __construct($left = 0, $bottom = 0, $right = 0, $top = 0)
    {
        $this->left = floatval($left);
        $this->bottom = floatval($bottom);
        $this->right = floatval($right);
        $this->top = floatval($top);
    }
    
    /**
     * @param array $value
     * @return self
     */
    public static function fromArray(array $value)
    {
        if (count($value) != 4) {
            throw new \InvalidArgumentException('Box array must be from 4 elements');
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
