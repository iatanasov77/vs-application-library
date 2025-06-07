<?php namespace Vankosoft\ApplicationBundle\Model;

use Vankosoft\ApplicationBundle\Model\Interfaces\LogEntryInterface;

class LogEntry implements LogEntryInterface
{
    /** @var int|null */
    protected $id;
    
    /** @var string|null */
    protected $action;
    
    /** @var \DateTime|null */
    protected $loggedAt;
    
    /** @var string|null */
    protected $objectId;
    
    /** @var string|null */
    protected $objectClass;
    
    /** @var int|null */
    protected $version;
    
    /** @var array<string, mixed>|null */
    protected $data;
    
    /** @var string|null */
    protected $username;
    
    /** @var string $locale */
    protected $locale;
    
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get action
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * Set action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    /**
     * Get object class
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }
    
    /**
     * Set object class
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;
    }
    
    /**
     * Get object id
     */
    public function getObjectId()
    {
        return $this->objectId;
    }
    
    /**
     * Set object id
     *
     * @param string $objectId
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;
    }
    
    /**
     * Get username
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * Get loggedAt
     */
    public function getLoggedAt()
    {
        return $this->loggedAt;
    }
    
    /**
     * Set loggedAt to "now"
     */
    public function setLoggedAt()
    {
        $this->loggedAt = new \DateTime();
    }
    
    /**
     * Get data
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Set data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * Set current version
     *
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
    
    /**
     * Get current version
     */
    public function getVersion()
    {
        return $this->version;
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
     * Set locale
     *
     * @param string $locale
     */
    public function setLocale( $locale )
    {
        $this->locale = $locale;
    }
}
