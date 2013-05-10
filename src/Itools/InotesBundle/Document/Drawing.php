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

/**
 * Class Drawing
 * @package Itools\InotesBundle\Document
 * @MongoDB\Document
 */
class Drawing {

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $strokes;


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
     * Set strokes
     *
     * @param string $strokes
     * @return self
     */
    public function setStrokes($strokes)
    {
        $this->strokes = $strokes;
        return $this;
    }

    /**
     * Get strokes
     *
     * @return string $strokes
     */
    public function getStrokes()
    {
        return $this->strokes;
    }
}
