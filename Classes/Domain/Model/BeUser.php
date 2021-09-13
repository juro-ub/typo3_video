<?php

namespace Jro\Videoportal\Domain\Model;

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
class BeUser extends \TYPO3\CMS\Extbase\Domain\Model\BackendUser
{

    /**
     * watchedComments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment>
     */
    protected $watchedComments;

    /**
     * observedComments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment>
     */
    protected $observedComments;

    /**
     * myComments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment>
     */

    protected $myComments;

    /**
     * __construct
     *
     * @return User
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
        $this->watchedComments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->observedComments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->myComments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();


    }

    /**
     * Adds a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $watchedComment
     * @return void
     */
    public function addWatchedComment(\Jro\Videoportal\Domain\Model\Comment $watchedComment)
    {
        $this->watchedComments->attach($watchedComment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $watchedComment The Comment to be removed
     * @return void
     */
    public function removeWatchedComment(\Jro\Videoportal\Domain\Model\Comment $watchedComment)
    {
        $this->watchedComments->detach($watchedComment);
    }

    /**
     * Returns the watchedComments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $watchedComments
     */
    public function getWatchedComments()
    {
        return $this->watchedComments;
    }

    /**
     * Sets the watchedComments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $watchedComments
     * @return void
     */
    public function setWatchedComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $watchedComments)
    {
        $this->watchedComments = $watchedComments;
    }

    /**
     * Adds a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $observedComment
     * @return void
     */
    public function addObservedComment(\Jro\Videoportal\Domain\Model\Comment $observedComment)
    {
        $this->observedComments->attach($observedComment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $observedCommentToRemove The Comment to be removed
     * @return void
     */
    public function removeObservedComment(\Jro\Videoportal\Domain\Model\Comment $observedCommentToRemove)
    {
        $this->observedComments->detach($observedCommentToRemove);
    }

    /**
     * Returns the observedComments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $observedComments
     */
    public function getObservedComments()
    {
        return $this->observedComments;
    }

    /**
     * Sets the observedComments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $observedComments
     * @return void
     */
    public function setObservedComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $observedComments)
    {
        $this->observedComments = $observedComments;
    }

    /**
     * Adds a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $myComment
     * @return void
     */
    public function addMyComment(\Jro\Videoportal\Domain\Model\Comment $myComment)
    {
        $this->myComments->attach($myComment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $myCommentToRemove The Comment to be removed
     * @return void
     */
    public function removeMyComment(\Jro\Videoportal\Domain\Model\Comment $myCommentToRemove)
    {
        $this->myComments->detach($myCommentToRemove);
    }

    /**
     * Returns the myComments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $myComments
     */
    public function getMyComments()
    {
        return $this->myComments;
    }

    /**
     * Sets the myComments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $myComments
     * @return void
     */
    public function setMyComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $myComments)
    {
        $this->myComments = $myComments;
    }

}

?>