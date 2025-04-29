<?php namespace Vankosoft\ApplicationBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonKeyValueTransformer implements DataTransformerInterface
{
    
    /**
     * @inheritDoc
     */
    public function transform( $value ): array
    {
        //echo '<pre>'; var_dump( $value ); die;
        if ( empty( $value ) ) {
            return [];
        }
        
        $transformed    = [];
        foreach ( $value as $key => $val ) {
            $transformed[]  = [
                'key'   => $key,
                'value' => $val,
            ];
        }
        
        //echo '<pre>'; var_dump( $transformed ); die;
        return $transformed;
    }
    
    /**
     * @ihneritdoc
     */
    public function reverseTransform( $value ): array
    {
        //echo '<pre>'; var_dump( $value ); die;
        if ( empty( $value ) ) {
            return [];
        }
        
        $reversed    = [];
        foreach ( $value as $val ) {
            $reversed[$val['key']] = $val['value'];
        }
        
        return $reversed;
    }
}
