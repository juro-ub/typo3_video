<?php

namespace Jro\Videoportal\Domain\Model;

use TYPO3\CMS\Extbase\Annotation;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Comment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * text
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 1, "maximum": 2000})
     */
    protected $text;

    /**
     * hidden
     * @var boolean
     */
    protected $hidden = FALSE;

    /**
     * time
     *
     * @var DateTime
     *
     */
    protected $crdate;

    /**
     * childs
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment>
     */
    protected $childs;

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $files;

    /**
     * __construct
     *
     * @return Comment
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */

        $this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->childs = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the comment
     *
     * @return string $comment
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the comment
     *
     * @param string $comment
     * @return void
     */
    public function setText($comment)
    {
        $this->text = $comment;
    }

    /**
     * Returns the crdate
     *
     * @return DateTime $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Sets the crdate
     *
     * @param DateTime $crdate
     * @return void
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Adds a Child
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $child
     * @return void
     */
    public function addChild(\Jro\Videoportal\Domain\Model\Comment $child)
    {
        $this->childs->attach($child);
    }

    /**
     * Removes a Child
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $childToRemove The Comment to be removed
     * @return void
     */
    public function removeChild(\Jro\Videoportal\Domain\Model\Comment $childToRemove)
    {
        $this->childs->detach($childToRemove);
    }

    /**
     * Returns the childs
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $childs
     */
    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Sets the childs
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $childs
     * @return void
     */
    public function setChilds(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $childs)
    {
        $this->childs = $childs;
    }

    /**
     * Adds a File
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function addFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file)
    {
        $this->files->attach($file);
    }

    /**
     * Removes a File
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileToRemove The File to be removed
     * @return void
     */
    public function removeFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $fileToRemove)
    {
        $this->files->detach($fileToRemove);
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
     * @return void
     */
    public function setFiles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $files)
    {
        $this->files = $files;
    }

    /**
     * Returns the hidden
     *
     * @return boolean $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the boolean state of hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return $this->getHidden();
    }
}

?>