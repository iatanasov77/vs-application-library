<?php namespace Vankosoft\CmsBundle\Component;

trait FileSizeTrait
{
    const suffixes = [
        ""=> 0,
        "Bytes"=>0,
        "KB"=>1,
        "K"=>1,
        "MB"=>2,
        "M"=>2,
        "GB"=>3,
        "G"=>3,
        "TB"=>4,
        "T"=>4,
        "PB"=>5,
        "P"=>5
    ];
    
    protected function convertToBytes( ?string $string ): ?int
    {
        if( ! $string ) {
            return null;
        }
        
        if ( \preg_match( '/([0-9\.]+) ?([a-z]*)/i', $string, $matches ) ) {
            $number = $matches[1];
            $suffix = $matches[2];
            
            if ( isset( self::suffixes[$suffix] ) ) {
                $bytes = \round( $number * \pow( 1024, self::suffixes[$suffix] ) );
                return $bytes;
            }
            
            return null;
        }
        
        return null;
    }
}
