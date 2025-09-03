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
    public function getAction(): ?string
    {
        return $this->action;
    }
    
    /**
     * Set action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }
    
    /**
     * Get object class
     */
    public function getObjectClass(): ?string
    {
        return $this->objectClass;
    }
    
    /**
     * Set object class
     */
    public function setObjectClass($objectClass): void
    {
        $this->objectClass = $objectClass;
    }
    
    /**
     * Get object id
     */
    public function getObjectId(): ?string
    {
        return $this->objectId;
    }
    
    /**
     * Set object id
     *
     * @param string $objectId
     */
    public function setObjectId($objectId): void
    {
        $this->objectId = $objectId;
    }
    
    /**
     * Get username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
    
    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }
    
    /**
     * Get loggedAt
     */
    public function getLoggedAt(): ?\DateTimeInterface
    {
        return $this->loggedAt;
    }
    
    /**
     * Set loggedAt to "now"
     */
    public function setLoggedAt(): void
    {
        $this->loggedAt = new \DateTime();
    }
    
    /**
     * Get data
     */
    public function getData(): ?array
    {
        return $this->data;
    }
    
    /**
     * Set data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
    
    /**
     * Set current version
     *
     * @param int $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }
    
    /**
     * Get current version
     */
    public function getVersion(): ?int
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
