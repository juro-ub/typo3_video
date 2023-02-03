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
class Watchcount extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * videoId
     *
     * @var \integer
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $videoId;

    /**
     * count
     *
     * @var \integer
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $count;

    /**
     * Returns the videoId
     *
     * @return \integer $videoId
     */
    public function getVideoId() {
        return $this->videoId;
    }

    /**
     * Sets the videoId
     *
     * @param \integer $videoId
     * @return void
     */
    public function setVideoId($videoId) {
        $this->videoId = $videoId;
    }

    /**
     * Returns the count
     *
     * @return \integer $count
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * Sets the count
     *
     * @param \integer $count
     * @return void
     */
    public function setCount($count) {
        $this->count = $count;
    }

}

?>