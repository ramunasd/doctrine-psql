<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Boolean array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BooleanArrayType extends AbstractArrayType
{
    const DECLARATION = 'boolean[]';
    const TYPE = 'boolean';
}
