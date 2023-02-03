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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class User extends AbstractEntity {

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
     * watchVideos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video>
     */
    protected $watchedVideos;

    /**
     * watchcount
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Watchcount>
     */
    protected $watchcount;

    /**
     * @var string
     */
    protected $username = '';

    /**
     * @var string
     */
    protected $password = '';

    /**
     * @var ObjectStorage<Group>
     */
    protected $usergroup;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $firstName = '';

    /**
     * @var string
     */
    protected $middleName = '';

    /**
     * @var string
     */
    protected $lastName = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $telephone = '';

    /**
     * @var string
     */
    protected $fax = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $zip = '';

    /**
     * @var string
     */
    protected $city = '';

    /**
     * @var string
     */
    protected $country = '';

    /**
     * @var string
     */
    protected $www = '';

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @var ObjectStorage<FileReference>
     */
    protected $image;

    /**
     * @var \DateTime|null
     */
    protected $lastlogin;

    /**
     * Constructs a new Front-End User
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username = '', $password = '') {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
        $this->username = $username;
        $this->password = $password;
        $this->usergroup = new ObjectStorage();
        $this->image = new ObjectStorage();
    }

    /**
     * Called again with initialize object, as fetching an entity from the DB does not use the constructor
     */
    public function initializeObject() {
        $this->usergroup = $this->usergroup ?? new ObjectStorage();
        $this->image = $this->image ?? new ObjectStorage();
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
        $this->observedComments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->myComments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->watchedVideos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->watchcount = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Adds a Video
     *
     * @param \Jro\Videoportal\Domain\Model\Video $watchVideo
     * @return void
     */
    public function addWatchedVideo(\Jro\Videoportal\Domain\Model\Video $watchVideo) {
        $this->watchedVideos->attach($watchVideo);
    }

    /**
     * Removes a Video
     *
     * @param \Jro\Videoportal\Domain\Model\Video $watchVideoToRemove The Video to be removed
     * @return void
     */
    public function removeWatchedVideo(\Jro\Videoportal\Domain\Model\Video $watchVideoToRemove) {
        $this->watchedVideos->detach($watchVideoToRemove);
    }

    /**
     * Returns the watchedVideos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $watchedVideos
     */
    public function getWatchedVideos() {
        return $this->watchedVideos;
    }

    /**
     * Sets the watchedVideos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $watchedVideos
     * @return void
     */
    public function setWatchedVideos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $watchedVideos) {
        $this->watchedVideos = $watchedVideos;
    }

    /**
     * Adds a Video
     *
     * @param \Jro\Videoportal\Domain\Model\Watchcount $watchVideo
     * @return void
     */
    public function addWatchcount(\Jro\Videoportal\Domain\Model\Watchcount $watchVideo) {
        $this->watchcount->attach($watchVideo);
    }

    /**
     * Removes a Video
     *
     * @param \Jro\Videoportal\Domain\Model\Watchcount $watchVideoToRemove The Video to be removed
     * @return void
     */
    public function removeWatchcount(\Jro\Videoportal\Domain\Model\Watchcount $watchVideoToRemove) {
        $this->watchcount->detach($watchVideoToRemove);
    }

    /**
     * Returns the watchedVideos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Watchcount> $watchedVideos
     */
    public function getWatchcount() {
        return $this->watchcount;
    }

    /**
     * Sets the watchedVideos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Watchcount> $watchedVideos
     * @return void
     */
    public function setWatchcount(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $watchedVideos) {
        $this->watchcount = $watchedVideos;
    }

    /**
     * Sets the username value
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Returns the username value
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Sets the password value
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Returns the password value
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Sets the usergroups. Keep in mind that the property is called "usergroup"
     * although it can hold several usergroups.
     *
     * @param ObjectStorage<Group> $usergroup
     */
    public function setUsergroup(ObjectStorage $usergroup) {
        $this->usergroup = $usergroup;
    }

    /**
     * Adds a usergroup to the frontend user
     *
     * @param Group $usergroup
     */
    public function addUsergroup(Group $usergroup) {
        $this->usergroup->attach($usergroup);
    }

    /**
     * Removes a usergroup from the frontend user
     *
     * @param Group $usergroup
     */
    public function removeUsergroup(Group $usergroup) {
        $this->usergroup->detach($usergroup);
    }

    /**
     * Returns the usergroups. Keep in mind that the property is called "usergroup"
     * although it can hold several usergroups.
     *
     * @return ObjectStorage<Group> An object storage containing the usergroup
     */
    public function getUsergroup() {
        return $this->usergroup;
    }

    /**
     * Sets the name value
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the name value
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the firstName value
     *
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * Returns the firstName value
     *
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Sets the middleName value
     *
     * @param string $middleName
     */
    public function setMiddleName($middleName) {
        $this->middleName = $middleName;
    }

    /**
     * Returns the middleName value
     *
     * @return string
     */
    public function getMiddleName() {
        return $this->middleName;
    }

    /**
     * Sets the lastName value
     *
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * Returns the lastName value
     *
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Sets the address value
     *
     * @param string $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * Returns the address value
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Sets the telephone value
     *
     * @param string $telephone
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    /**
     * Returns the telephone value
     *
     * @return string
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Sets the fax value
     *
     * @param string $fax
     */
    public function setFax($fax) {
        $this->fax = $fax;
    }

    /**
     * Returns the fax value
     *
     * @return string
     */
    public function getFax() {
        return $this->fax;
    }

    /**
     * Sets the email value
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Returns the email value
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Sets the title value
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Returns the title value
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Sets the zip value
     *
     * @param string $zip
     */
    public function setZip($zip) {
        $this->zip = $zip;
    }

    /**
     * Returns the zip value
     *
     * @return string
     */
    public function getZip() {
        return $this->zip;
    }

    /**
     * Sets the city value
     *
     * @param string $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * Returns the city value
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Sets the country value
     *
     * @param string $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * Returns the country value
     *
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Sets the www value
     *
     * @param string $www
     */
    public function setWww($www) {
        $this->www = $www;
    }

    /**
     * Returns the www value
     *
     * @return string
     */
    public function getWww() {
        return $this->www;
    }

    /**
     * Sets the company value
     *
     * @param string $company
     */
    public function setCompany($company) {
        $this->company = $company;
    }

    /**
     * Returns the company value
     *
     * @return string
     */
    public function getCompany() {
        return $this->company;
    }

    /**
     * Sets the image value
     *
     * @param ObjectStorage<FileReference> $image
     */
    public function setImage(ObjectStorage $image) {
        $this->image = $image;
    }

    /**
     * Gets the image value
     *
     * @return ObjectStorage<FileReference>
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Sets the lastlogin value
     *
     * @param \DateTime $lastlogin
     */
    public function setLastlogin(\DateTime $lastlogin) {
        $this->lastlogin = $lastlogin;
    }

    /**
     * Returns the lastlogin value
     *
     * @return \DateTime
     */
    public function getLastlogin() {
        return $this->lastlogin;
    }

}

?>