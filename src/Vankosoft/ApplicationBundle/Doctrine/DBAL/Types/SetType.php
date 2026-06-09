<?php namespace Vankosoft\ApplicationBundle\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;

class SetType extends Type
{
    public const SET = 'set'; // Your custom type name
    
    public function getSQLDeclaration( array $column, AbstractPlatform $platform ): string
    {
        /*
         * Define how the column looks in MySQL, e.g. SET('value1','value2')
         */
        
        return \sprintf( "SET('%s')", implode( "','", $column['allowedValues'] ?? [] ) );
    }
    
    public function convertToDatabaseValue( $value, AbstractPlatform $platform ): ?string
    {
        // Convert PHP array to comma-separated string for DB
        if ( empty( $value ) ) {
            return null;
        }
        
        if ( \is_array( $value ) ) {
            return implode( ',', $value );
        }
        return ( string ) $value;
    }
    
    public function getName(): string
    {
        return self::SET;
    }
}
