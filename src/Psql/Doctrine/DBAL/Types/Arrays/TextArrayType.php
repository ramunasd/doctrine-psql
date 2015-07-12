<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Text array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class TextArrayType extends AbstractArrayType
{
    const DECLARATION = 'text[]';
    const TYPE = 'text';
}
