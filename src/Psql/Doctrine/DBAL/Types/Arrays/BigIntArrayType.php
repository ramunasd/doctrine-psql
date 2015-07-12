<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Big integer array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BigIntArrayType extends AbstractArrayType
{
    const DECLARATION = 'bigint[]';
    const TYPE = 'bigint';
}
