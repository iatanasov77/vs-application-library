<?php namespace Vankosoft\ApplicationBundle\Component\Uploader;

use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Webmozart\Assert\Assert;

use Vankosoft\CmsBundle\Component\Uploader\AbstractFileUploader;
use Vankosoft\CmsBundle\Model\Interfaces\FileInterface;

class KanbanboardTaskAttachmentUploader extends AbstractFileUploader
{
    public function upload( FileInterface $sliderPhoto ): void
    {
        if ( ! $sliderPhoto->hasFile() ) {
            return;
        }
        
        $file = $sliderPhoto->getFile();
        
        /** @var File $file */
        Assert::isInstanceOf( $file, File::class );
        
        if ( null !== $sliderPhoto->getPath() && $this->has( $sliderPhoto->getPath() ) ) {
            $this->remove( $sliderPhoto->getPath() );
        }
        
        do {
            $path = $this->filePathGenerator->generate( $sliderPhoto );
        } while ( $this->isAdBlockingProne( $path ) || $this->has( $path ) );
        
        $sliderPhoto->setPath( $path );
        
        $this->filesystem->write(
            $sliderPhoto->getPath(),
            file_get_contents( $sliderPhoto->getFile()->getPathname() )
        );
        
        $sliderPhoto->setType( $this->filesystem->mimeType( $sliderPhoto->getPath() ) );
    }
}
