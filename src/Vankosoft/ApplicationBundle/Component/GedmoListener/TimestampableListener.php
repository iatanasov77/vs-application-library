<?php namespace Vankosoft\ApplicationBundle\Component\GedmoListener;

use Gedmo\Timestampable\TimestampableListener as GedmoTimestampableListener;
use Vankosoft\ApplicationBundle\Model\Interfaces\TimestampableCancelInterface;

/**
 * Usage
 * ====================================================
 * $em = $this->doctrine->getManager();
        
 * $video->addWatchedByUsers( $user );
 * $video->cancelTimestampable( true );
 * 
 * $em->persist( $video );
 * $em->flush();
 */
class TimestampableListener extends GedmoTimestampableListener
{
    protected function updateField( $object, $eventAdapter, $meta, $field ): void
    {
        /** @var \Doctrine\Orm\Mapping\ClassMetadata $meta */
        $property = $meta->getReflectionProperty( $field );
        $newValue = $this->getFieldValue( $meta, $field, $eventAdapter );
        
        if ( ! $this->isTimestampableCanceled( $object ) ) {
            $property->setValue( $object, $newValue );
        }
    }
    
    private function isTimestampableCanceled( $object ): bool
    {
        if( ! $object instanceof TimestampableCancelInterface ) {
            return false;
        }
        
        return $object->isTimestampableCanceled();
    }
}
