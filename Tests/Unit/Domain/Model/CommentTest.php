<?php

namespace Jro\Videoportal\Tests;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \Jro\Videoportal\Domain\Model\Comment.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Videoportal
 *
 */
class CommentTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

    /**
     * @var \Jro\Videoportal\Domain\Model\Comment
     */
    protected $fixture;

    public function setUp() {
        $this->fixture = new \Jro\Videoportal\Domain\Model\Comment();
    }

    public function tearDown() {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function getCommentReturnsInitialValueForString() {
        
    }

    /**
     * @test
     */
    public function setCommentForStringSetsComment() {
        $this->fixture->setComment('Conceived at T3CON10');

        $this->assertSame(
                'Conceived at T3CON10',
                $this->fixture->getComment()
        );
    }

    /**
     * @test
     */
    public function getStatusReturnsInitialValueForOolean() {
        
    }

    /**
     * @test
     */
    public function setStatusForOoleanSetsStatus() {
        
    }

    /**
     * @test
     */
    public function getTimeReturnsInitialValueForDateTime() {
        
    }

    /**
     * @test
     */
    public function setTimeForDateTimeSetsTime() {
        
    }

    /**
     * @test
     */
    public function getParentReturnsInitialValueForComment() {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
        $this->assertEquals(
                $newObjectStorage,
                $this->fixture->getParent()
        );
    }

    /**
     * @test
     */
    public function setParentForObjectStorageContainingCommentSetsParent() {
        $parent = new \Jro\Videoportal\Domain\Model\Comment();
        $objectStorageHoldingExactlyOneParent = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
        $objectStorageHoldingExactlyOneParent->attach($parent);
        $this->fixture->setParent($objectStorageHoldingExactlyOneParent);

        $this->assertSame(
                $objectStorageHoldingExactlyOneParent,
                $this->fixture->getParent()
        );
    }

    /**
     * @test
     */
    public function addParentToObjectStorageHoldingParent() {
        $parent = new \Jro\Videoportal\Domain\Model\Comment();
        $objectStorageHoldingExactlyOneParent = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
        $objectStorageHoldingExactlyOneParent->attach($parent);
        $this->fixture->addParent($parent);

        $this->assertEquals(
                $objectStorageHoldingExactlyOneParent,
                $this->fixture->getParent()
        );
    }

    /**
     * @test
     */
    public function removeParentFromObjectStorageHoldingParent() {
        $parent = new \Jro\Videoportal\Domain\Model\Comment();
        $localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
        $localObjectStorage->attach($parent);
        $localObjectStorage->detach($parent);
        $this->fixture->addParent($parent);
        $this->fixture->removeParent($parent);

        $this->assertEquals(
                $localObjectStorage,
                $this->fixture->getParent()
        );
    }

}

?>