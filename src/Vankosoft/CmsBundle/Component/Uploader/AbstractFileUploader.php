<?php namespace Vankosoft\CmsBundle\Component\Uploader;

use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Webmozart\Assert\Assert;

use Vankosoft\CmsBundle\Component\Generator\FilePathGeneratorInterface;
use Vankosoft\CmsBundle\Component\Generator\UploadedFilePathGenerator;
use Vankosoft\CmsBundle\Model\Interfaces\FileInterface;

abstract class AbstractFileUploader implements FileUploaderInterface
{
    /** @var Filesystem */
    protected $filesystem;
    
    /** @var FilePathGeneratorInterface */
    protected $filePathGenerator;
    
    public function __construct(
        Filesystem $filesystem,
        ?FilePathGeneratorInterface $filePathGenerator = null
    ) {
            $this->filesystem = $filesystem;
            
            if ( $filePathGenerator === null ) {
                @trigger_error( sprintf(
                    'Not passing an $filePathGenerator to %s constructor is deprecated since Sylius 1.6 and will be not possible in Sylius 2.0.',
                    self::class
                ), \E_USER_DEPRECATED );
            }
            
            $this->filePathGenerator = $filePathGenerator ?? new UploadedFilePathGenerator();
    }
    
    abstract public function upload( FileInterface $filemanagerFile ): void;
    
    public function remove( string $path ): bool
    {
        if ( $this->has( $path ) ) {
            return $this->filesystem->delete( $path );
        }
        
        return false;
    }
    
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }
    
    public function fileSize( FileInterface $filemanagerFile )
    {
        if ( $filemanagerFile->getFile() ) {
            return $filemanagerFile->getFile()->getSize();
        } else {
            return $this->filesystem->fileSize( $filemanagerFile->getPath() );
        }
    }
    
    protected function has( string $path ): bool
    {
        return $this->filesystem->has( $path );
    }
    
    /**
     * Will return true if the path is prone to be blocked by ad blockers
     */
    protected function isAdBlockingProne( string $path ): bool
    {
        return strpos( $path, 'ad' ) !== false;
    }
}
