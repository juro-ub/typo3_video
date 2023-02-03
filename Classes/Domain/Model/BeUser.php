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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BeUser extends AbstractEntity {

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
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $userName = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var bool
     */
    protected $isAdministrator = false;

    /**
     * @var bool
     */
    protected $isDisabled = false;

    /**
     * @var \DateTime|null
     */
    protected $startDateAndTime;

    /**
     * @var \DateTime|null
     */
    protected $endDateAndTime;

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $realName = '';

    /**
     * @var \DateTime|null
     */
    protected $lastLoginDateAndTime;

    /**
     * __construct
     *
     * @return User
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
    public function addWatchedComment(\Jro\Videoportal\Domain\Model\Comment $watchedComment) {
        $this->watchedComments->attach($watchedComment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $watchedComment The Comment to be removed
     * @return void
     */
    public function removeWatchedComment(\Jro\Videoportal\Domain\Model\Comment $watchedComment) {
        $this->watchedComments->detach($watchedComment);
    }

    /**
     * Returns the watchedComments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $watchedComments
     */
    public function getWatchedComments() {
        return $this->watchedComments;
    }

    /**
     * Sets the watchedComments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $watchedComments
     * @return void
     */
    public function setWatchedComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $watchedComments) {
        $this->watchedComments = $watchedComments;
    }

    /**
     * Adds a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $observedComment
     * @return void
     */
    public function addObservedComment(\Jro\Videoportal\Domain\Model\Comment $observedComment) {
        $this->observedComments->attach($observedComment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $observedCommentToRemove The Comment to be removed
     * @return void
     */
    public function removeObservedComment(\Jro\Videoportal\Domain\Model\Comment $observedCommentToRemove) {
        $this->observedComments->detach($observedCommentToRemove);
    }

    /**
     * Returns the observedComments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $observedComments
     */
    public function getObservedComments() {
        return $this->observedComments;
    }

    /**
     * Sets the observedComments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $observedComments
     * @return void
     */
    public function setObservedComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $observedComments) {
        $this->observedComments = $observedComments;
    }

    /**
     * Adds a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $myComment
     * @return void
     */
    public function addMyComment(\Jro\Videoportal\Domain\Model\Comment $myComment) {
        $this->myComments->attach($myComment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $myCommentToRemove The Comment to be removed
     * @return void
     */
    public function removeMyComment(\Jro\Videoportal\Domain\Model\Comment $myCommentToRemove) {
        $this->myComments->detach($myCommentToRemove);
    }

    /**
     * Returns the myComments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $myComments
     */
    public function getMyComments() {
        return $this->myComments;
    }

    /**
     * Sets the myComments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $myComments
     * @return void
     */
    public function setMyComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $myComments) {
        $this->myComments = $myComments;
    }

    /**
     * Gets the user name.
     *
     * @return string the user name, will not be empty
     */
    public function getUserName() {
        return $this->userName;
    }

    /**
     * Sets the user name.
     *
     * @param string $userName the user name to set, must not be empty
     */
    public function setUserName($userName) {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Checks whether this user is an administrator.
     *
     * @return bool whether this user is an administrator
     */
    public function getIsAdministrator() {
        return $this->isAdministrator;
    }

    /**
     * Sets whether this user should be an administrator.
     *
     * @param bool $isAdministrator whether this user should be an administrator
     */
    public function setIsAdministrator($isAdministrator) {
        $this->isAdministrator = $isAdministrator;
    }

    /**
     * Checks whether this user is disabled.
     *
     * @return bool whether this user is disabled
     */
    public function getIsDisabled() {
        return $this->isDisabled;
    }

    /**
     * Sets whether this user is disabled.
     *
     * @param bool $isDisabled whether this user is disabled
     */
    public function setIsDisabled($isDisabled) {
        $this->isDisabled = $isDisabled;
    }

    /**
     * Returns the point in time from which this user is enabled.
     *
     * @return \DateTime|null the start date and time
     */
    public function getStartDateAndTime() {
        return $this->startDateAndTime;
    }

    /**
     * Sets the point in time from which this user is enabled.
     *
     * @param \DateTime|null $dateAndTime the start date and time
     */
    public function setStartDateAndTime(\DateTime $dateAndTime = null) {
        $this->startDateAndTime = $dateAndTime;
    }

    /**
     * Returns the point in time before which this user is enabled.
     *
     * @return \DateTime|null the end date and time
     */
    public function getEndDateAndTime() {
        return $this->endDateAndTime;
    }

    /**
     * Sets the point in time before which this user is enabled.
     *
     * @param \DateTime|null $dateAndTime the end date and time
     */
    public function setEndDateAndTime(\DateTime $dateAndTime = null) {
        $this->endDateAndTime = $dateAndTime;
    }

    /**
     * Gets the e-mail address of this user.
     *
     * @return string the e-mail address, might be empty
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Sets the e-mail address of this user.
     *
     * @param string $email the e-mail address, may be empty
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Returns this user's real name.
     *
     * @return string the real name. might be empty
     */
    public function getRealName() {
        return $this->realName;
    }

    /**
     * Sets this user's real name.
     *
     * @param string $name the user's real name, may be empty.
     */
    public function setRealName($name) {
        $this->realName = $name;
    }

    /**
     * Checks whether this user is currently activated.
     *
     * This function takes the "disabled" flag, the start date/time and the end date/time into account.
     *
     * @return bool whether this user is currently activated
     */
    public function isActivated() {
        return !$this->getIsDisabled() && $this->isActivatedViaStartDateAndTime() && $this->isActivatedViaEndDateAndTime();
    }

    /**
     * Checks whether this user is activated as far as the start date and time is concerned.
     *
     * @return bool whether this user is activated as far as the start date and time is concerned
     */
    protected function isActivatedViaStartDateAndTime() {
        if ($this->getStartDateAndTime() === null) {
            return true;
        }
        $now = new \DateTime('now');
        return $this->getStartDateAndTime() <= $now;
    }

    /**
     * Checks whether this user is activated as far as the end date and time is concerned.
     *
     * @return bool whether this user is activated as far as the end date and time is concerned
     */
    protected function isActivatedViaEndDateAndTime() {
        if ($this->getEndDateAndTime() === null) {
            return true;
        }
        $now = new \DateTime('now');
        return $now <= $this->getEndDateAndTime();
    }

    /**
     * Gets this user's last login date and time.
     *
     * @return \DateTime|null this user's last login date and time, will be NULL if this user has never logged in before
     */
    public function getLastLoginDateAndTime() {
        return $this->lastLoginDateAndTime;
    }

    /**
     * Sets this user's last login date and time.
     *
     * @param \DateTime|null $dateAndTime this user's last login date and time
     */
    public function setLastLoginDateAndTime(\DateTime $dateAndTime = null) {
        $this->lastLoginDateAndTime = $dateAndTime;
    }

}

?>