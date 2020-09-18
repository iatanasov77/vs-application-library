<?php namespace VS\ApplicationBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

class Site implements ResourceInterface
{   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64, nullable=false)
     */
    protected $title;
    
    /**
     * @ORM\OneToMany(targetEntity="Settings", mappedBy="site")
     */
    private $settings;
    
    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }
    
    /**
     * @return Collection|Settings[]
     */
    public function getSettings(): Collection
    {
        return $this->settings;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
  
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setText($text)
    {
        $this->text = $text;
        
        return $this;
    }
}
