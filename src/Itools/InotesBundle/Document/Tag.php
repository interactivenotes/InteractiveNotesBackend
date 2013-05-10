<?php
/**
 * Created by JetBrains PhpStorm.
 * User: christian
 * Date: 10.05.13
 * Time: 18:06
 * To change this template use File | Settings | File Templates.
 */

namespace Itools\InotesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Tag
 * @package Itools\InotesBundle\Document
 * @MongoDB\Document
 */
class Tag {

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\String
     */
    protected $userId;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Note")
     */
    protected $notes;
    public function __construct()
    {
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get userId
     *
     * @return string $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Add notes
     *
     * @param Itools\InotesBundle\Document\Note $notes
     */
    public function addNote(\Itools\InotesBundle\Document\Note $notes)
    {
        $this->notes[] = $notes;
    }

    /**
    * Remove notes
    *
    * @param <variableType$notes
    */
    public function removeNote(\Itools\InotesBundle\Document\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return Doctrine\Common\Collections\Collection $notes
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
