<?php

namespace Psql\Doctrine\DBAL\Types\Arrays;

/**
 * Hstore array type
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class HstoreArrayType extends AbstractArrayType
{
    const DECLARATION = 'hstore[]';
    const TYPE = 'hstore';
}
