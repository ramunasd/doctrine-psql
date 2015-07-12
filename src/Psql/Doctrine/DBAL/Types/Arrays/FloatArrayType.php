<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Float array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class FloatArrayType extends AbstractArrayType
{
    const DECLARATION = 'float[]';
    const TYPE = 'float';
}
