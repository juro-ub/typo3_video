<?php

namespace Jro\Videoportal\Domain\Model;

/* * *************************************************************
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
 * ************************************************************* */

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 1, "maximum": 50})
     */
    protected $title;

    /**
     * description
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 0, "maximum": 500})
     * @var string
     *
     */
    protected $description;

    /**
     * hidden
     * @var boolean
     */
    protected $hidden = FALSE;

    /**
     * parent
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Category>
     */
    protected $parent;

    /**
     * __construct
     *
     * @return Category
     */
    public function __construct() {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects() {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->parent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Returns the hidden
     *
     * @return boolean $hidden
     */
    public function getHidden() {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }

    /**
     * Returns the boolean state of hidden
     *
     * @return boolean
     */
    public function isHidden() {
        return $this->getHidden();
    }

    /**
     * Adds a Category
     *
     * @param \Jro\Videoportal\Domain\Model\Category $parent
     * @return void
     */
    public function addParent(\Jro\Videoportal\Domain\Model\Category $parent) {
        $this->parent->attach($parent);
    }

    /**
     * Removes a Category
     *
     * @param \Jro\Videoportal\Domain\Model\Category $parentToRemove The Category to be removed
     * @return void
     */
    public function removeParent(\Jro\Videoportal\Domain\Model\Category $parentToRemove) {
        $this->parent->detach($parentToRemove);
    }

    /**
     * Returns the parent
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Category> $parent
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Sets the parent
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Category> $parent
     * @return void
     */
    public function setParent(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $parent) {
        $this->parent = $parent;
    }

}

?>