<?php namespace Vankosoft\ApplicationBundle\Model;

use Vankosoft\ApplicationBundle\Model\Interfaces\TranslationInterface;

class Translation implements TranslationInterface
{
    /** @var int */
    protected $id;
    
    /** @var string */
    protected $locale;
    
    /** @var string */
    protected $objectClass;
    
    /** @var string */
    protected $field;
    
    /** @var string */
    protected $foreignKey;
    
    /** @var string */
    protected $content;
    
    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return static
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        
        return $this;
    }
    
    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Set field
     *
     * @param string $field
     *
     * @return static
     */
    public function setField($field)
    {
        $this->field = $field;
        
        return $this;
    }
    
    /**
     * Get field
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
    
    /**
     * Set object class
     *
     * @param string $objectClass
     *
     * @return static
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;
        
        return $this;
    }
    
    /**
     * Get objectClass
     *
     * @return string
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }
    
    /**
     * Set foreignKey
     *
     * @param string $foreignKey
     *
     * @return static
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;
        
        return $this;
    }
    
    /**
     * Get foreignKey
     *
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }
    
    /**
     * Set content
     *
     * @param string $content
     *
     * @return static
     */
    public function setContent($content)
    {
        $this->content = $content;
        
        return $this;
    }
    
    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
