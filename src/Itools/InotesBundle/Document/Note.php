<?php
/**
 * Created by JetBrains PhpStorm.
 * User: christian
 * Date: 10.05.13
 * Time: 16:59
 * To change this template use File | Settings | File Templates.
 */

namespace Itools\InotesBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation AS SSA;

/**
 * Class Note
 * @package Itools\InotesBundle\Document
 * @MongoDB\Document
 */
class Note {

    /**
     * @MongoDB\Id
     * @SSA\Type("string")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @SSA\Type("string")
     */
    protected $text;

    /**
     * @MongoDB\Date
     * @SSA\Type("DateTime")
     */
    protected $creationDate;

    /**
     * @MongoDB\Date
     * @SSA\Type("DateTime")
     */
    protected $modificationDate;

    /**
     * @MongoDB\String
     * @SSA\Type("string")
     */
    protected $thumbnail;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Drawing")
     * @SSA\Type("Itools\InotesBundle\Document\Drawing")
     */
    protected $drawing;

    /**
     * @MongoDB\String
     * @SSA\Type("string")
     */
    protected $userId;

    /**
     * @MongoDB\Boolean
     * @SSA\Type("boolean")
     */
    protected $sticky;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Tag")
     * @SSA\Type("ArrayCollection<Itools\InotesBundle\Document\Tag>")
     */
    protected $tags;


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
     * Set text
     *
     * @param string $text
     * @return self
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set creationDate
     *
     * @param date $creationDate
     * @return self
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return date $creationDate
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set modificationDate
     *
     * @param date $modificationDate
     * @return self
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
        return $this;
    }

    /**
     * Get modificationDate
     *
     * @return date $modificationDate
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return self
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string $thumbnail
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
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
     * Set sticky
     *
     * @param boolean $sticky
     * @return self
     */
    public function setSticky($sticky)
    {
        $this->sticky = $sticky;
        return $this;
    }

    /**
     * Get sticky
     *
     * @return boolean $sticky
     */
    public function getSticky()
    {
        return $this->sticky;
    }
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set drawing
     *
     * @param Itools\InotesBundle\Document\Drawing $drawing
     * @return self
     */
    public function setDrawing(\Itools\InotesBundle\Document\Drawing $drawing)
    {
        $this->drawing = $drawing;
        return $this;
    }

    /**
     * Get drawing
     *
     * @return Itools\InotesBundle\Document\Drawing $drawing
     */
    public function getDrawing()
    {
        return $this->drawing;
    }

    /**
     * Add tags
     *
     * @param Itools\InotesBundle\Document\Tag $tags
     */
    public function addTag(\Itools\InotesBundle\Document\Tag $tags)
    {
        $this->tags[] = $tags;
    }

    /**
    * Remove tags
    *
    * @param <variableType$tags
    */
    public function removeTag(\Itools\InotesBundle\Document\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
}
