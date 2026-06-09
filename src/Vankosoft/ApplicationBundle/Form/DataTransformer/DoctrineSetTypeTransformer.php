<?php namespace Vankosoft\ApplicationBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class DoctrineSetTypeTransformer implements DataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform( $value ): array
    {
        //echo '<pre>Transform'; var_dump( $value ); die;
        if ( empty( $value ) ) {
            return [];
        }
        
        return \explode( ',' , $value );
    }
    
    /**
     * @ihneritdoc
     */
    public function reverseTransform( $value ): array
    {
        //echo '<pre> Reverse Transform'; var_dump( $value ); die;
        if ( empty( $value ) ) {
            return [];
        }
        
        $reversed    = [];
        foreach ( $value as $val ) {
            $reversed[] = $val;
        }
        
        return $reversed;
    }
}
