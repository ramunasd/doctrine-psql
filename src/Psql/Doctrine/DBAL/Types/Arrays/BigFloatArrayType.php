<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Big float array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BigFloatArrayType extends AbstractArrayType
{
    const DECLARATION = 'bigfloat[]';
    const TYPE = 'bigfloat';
}
