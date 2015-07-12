<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Small integer array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class SmallIntArrayType extends AbstractArrayType
{
    const DECLARATION = 'smallint[]';
    const TYPE = 'smallint';
}
