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
    /** @var int */
    public $left = 0;

    /** @var int */
    public $bottom = 0;

    /** @var int */
    public $right = 0;

    /** @var int */
    public $top = 0;

    /**
     * @param int $left
     * @param int $bottom
     * @param int $right
     * @param int $top
     */
    public function __construct($left = 0, $bottom = 0, $right = 0, $top = 0)
    {
        $this->left = $left;
        $this->bottom = $bottom;
        $this->right = $right;
        $this->top = $top;
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
