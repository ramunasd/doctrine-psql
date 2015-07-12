<?php

namespace Psql\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Timestamp type with timezone
 * 
 * @author ramunasd <ieskok@ramuno.lt>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class DateTimeTzType extends DateTimeType
{
    const FORMAT = 'Y-m-d H:i:s.uO';

    /**
     *
     * @var string
     */
    const NAME = 'timestamp_tz';

    /**
     * (non-PHPdoc)
     * 
     * @see \Doctrine\DBAL\Types\Type::getName()
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Doctrine\DBAL\Types\Type::getSQLDeclaration()
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'timestamp with timezone';
    }
}
