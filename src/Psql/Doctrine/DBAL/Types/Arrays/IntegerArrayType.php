<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Integer array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class IntegerArrayType extends AbstractArrayType
{
    const DECLARATION = 'integer[]';
    const TYPE = 'integer';
}
