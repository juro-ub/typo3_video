<?php

namespace Jro\Videoportal\Tests;
/***************************************************************
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
 ***************************************************************/

/**
 * Test case for class \Jro\Videoportal\Domain\Model\Video.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Videoportal
 *
 */
class VideoTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Jro\Videoportal\Domain\Model\Video
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Jro\Videoportal\Domain\Model\Video();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getPathMp4ReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPathMp4ForStringSetsPathMp4() { 
		$this->fixture->setPathMp4('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPathMp4()
		);
	}
	
	/**
	 * @test
	 */
	public function getPathWebmReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPathWebmForStringSetsPathWebm() { 
		$this->fixture->setPathWebm('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPathWebm()
		);
	}
	
	/**
	 * @test
	 */
	public function getPathOggReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPathOggForStringSetsPathOgg() { 
		$this->fixture->setPathOgg('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPathOgg()
		);
	}
	
	/**
	 * @test
	 */
	public function getTimeReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setTimeForDateTimeSetsTime() { }
	
	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getAboutReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAboutForStringSetsAbout() { 
		$this->fixture->setAbout('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAbout()
		);
	}
	
	/**
	 * @test
	 */
	public function getExamRelevantReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setExamRelevantForOoleanSetsExamRelevant() { }
	
	/**
	 * @test
	 */
	public function getMetaKeywordsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setMetaKeywordsForStringSetsMetaKeywords() { 
		$this->fixture->setMetaKeywords('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMetaKeywords()
		);
	}
	
	/**
	 * @test
	 */
	public function getMetaDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setMetaDescriptionForStringSetsMetaDescription() { 
		$this->fixture->setMetaDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMetaDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getMetaTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setMetaTitleForStringSetsMetaTitle() { 
		$this->fixture->setMetaTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMetaTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getLearningObjectivesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLearningObjectivesForStringSetsLearningObjectives() { 
		$this->fixture->setLearningObjectives('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLearningObjectives()
		);
	}
	
	/**
	 * @test
	 */
	public function getThumbnailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setThumbnailForStringSetsThumbnail() { 
		$this->fixture->setThumbnail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getThumbnail()
		);
	}
	
	/**
	 * @test
	 */
	public function getTargetGroupReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTargetGroupForStringSetsTargetGroup() { 
		$this->fixture->setTargetGroup('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTargetGroup()
		);
	}
	
	/**
	 * @test
	 */
	public function getLevelReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLevelForStringSetsLevel() { 
		$this->fixture->setLevel('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLevel()
		);
	}
	
	/**
	 * @test
	 */
	public function getAccessibilityReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setAccessibilityForStringSetsAccessibility() { 
		$this->fixture->setAccessibility('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getAccessibility()
		);
	}
	
	/**
	 * @test
	 */
	public function getTagsReturnsInitialValueForTag() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getTags()
		);
	}

	/**
	 * @test
	 */
	public function setTagsForObjectStorageContainingTagSetsTags() { 
		$tag = new \Jro\Videoportal\Domain\Model\Tag();
		$objectStorageHoldingExactlyOneTags = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneTags->attach($tag);
		$this->fixture->setTags($objectStorageHoldingExactlyOneTags);

		$this->assertSame(
			$objectStorageHoldingExactlyOneTags,
			$this->fixture->getTags()
		);
	}
	
	/**
	 * @test
	 */
	public function addTagToObjectStorageHoldingTags() {
		$tag = new \Jro\Videoportal\Domain\Model\Tag();
		$objectStorageHoldingExactlyOneTag = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneTag->attach($tag);
		$this->fixture->addTag($tag);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneTag,
			$this->fixture->getTags()
		);
	}

	/**
	 * @test
	 */
	public function removeTagFromObjectStorageHoldingTags() {
		$tag = new \Jro\Videoportal\Domain\Model\Tag();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($tag);
		$localObjectStorage->detach($tag);
		$this->fixture->addTag($tag);
		$this->fixture->removeTag($tag);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getTags()
		);
	}
	
	/**
	 * @test
	 */
	public function getLinksReturnsInitialValueForLink() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getLinks()
		);
	}

	/**
	 * @test
	 */
	public function setLinksForObjectStorageContainingLinkSetsLinks() { 
		$link = new \Jro\Videoportal\Domain\Model\Link();
		$objectStorageHoldingExactlyOneLinks = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneLinks->attach($link);
		$this->fixture->setLinks($objectStorageHoldingExactlyOneLinks);

		$this->assertSame(
			$objectStorageHoldingExactlyOneLinks,
			$this->fixture->getLinks()
		);
	}
	
	/**
	 * @test
	 */
	public function addLinkToObjectStorageHoldingLinks() {
		$link = new \Jro\Videoportal\Domain\Model\Link();
		$objectStorageHoldingExactlyOneLink = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneLink->attach($link);
		$this->fixture->addLink($link);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneLink,
			$this->fixture->getLinks()
		);
	}

	/**
	 * @test
	 */
	public function removeLinkFromObjectStorageHoldingLinks() {
		$link = new \Jro\Videoportal\Domain\Model\Link();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($link);
		$localObjectStorage->detach($link);
		$this->fixture->addLink($link);
		$this->fixture->removeLink($link);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getLinks()
		);
	}
	
	/**
	 * @test
	 */
	public function getCategoriesReturnsInitialValueForCategory() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function setCategoriesForObjectStorageContainingCategorySetsCategories() { 
		$category = new \Jro\Videoportal\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategories = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneCategories->attach($category);
		$this->fixture->setCategories($objectStorageHoldingExactlyOneCategories);

		$this->assertSame(
			$objectStorageHoldingExactlyOneCategories,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategories() {
		$category = new \Jro\Videoportal\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneCategory->attach($category);
		$this->fixture->addCategory($category);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneCategory,
			$this->fixture->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategories() {
		$category = new \Jro\Videoportal\Domain\Model\Category();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($category);
		$localObjectStorage->detach($category);
		$this->fixture->addCategory($category);
		$this->fixture->removeCategory($category);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getCategories()
		);
	}
	
	/**
	 * @test
	 */
	public function getFilesReturnsInitialValueForFile() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function setFilesForObjectStorageContainingFileSetsFiles() { 
		$file = new \Jro\Videoportal\Domain\Model\File();
		$objectStorageHoldingExactlyOneFiles = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneFiles->attach($file);
		$this->fixture->setFiles($objectStorageHoldingExactlyOneFiles);

		$this->assertSame(
			$objectStorageHoldingExactlyOneFiles,
			$this->fixture->getFiles()
		);
	}
	
	/**
	 * @test
	 */
	public function addFileToObjectStorageHoldingFiles() {
		$file = new \Jro\Videoportal\Domain\Model\File();
		$objectStorageHoldingExactlyOneFile = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneFile->attach($file);
		$this->fixture->addFile($file);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneFile,
			$this->fixture->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function removeFileFromObjectStorageHoldingFiles() {
		$file = new \Jro\Videoportal\Domain\Model\File();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($file);
		$localObjectStorage->detach($file);
		$this->fixture->addFile($file);
		$this->fixture->removeFile($file);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getFiles()
		);
	}
	
	/**
	 * @test
	 */
	public function getTranscriptsReturnsInitialValueForTranscript() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getTranscripts()
		);
	}

	/**
	 * @test
	 */
	public function setTranscriptsForObjectStorageContainingTranscriptSetsTranscripts() { 
		$transcript = new \Jro\Videoportal\Domain\Model\Transcript();
		$objectStorageHoldingExactlyOneTranscripts = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneTranscripts->attach($transcript);
		$this->fixture->setTranscripts($objectStorageHoldingExactlyOneTranscripts);

		$this->assertSame(
			$objectStorageHoldingExactlyOneTranscripts,
			$this->fixture->getTranscripts()
		);
	}
	
	/**
	 * @test
	 */
	public function addTranscriptToObjectStorageHoldingTranscripts() {
		$transcript = new \Jro\Videoportal\Domain\Model\Transcript();
		$objectStorageHoldingExactlyOneTranscript = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneTranscript->attach($transcript);
		$this->fixture->addTranscript($transcript);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneTranscript,
			$this->fixture->getTranscripts()
		);
	}

	/**
	 * @test
	 */
	public function removeTranscriptFromObjectStorageHoldingTranscripts() {
		$transcript = new \Jro\Videoportal\Domain\Model\Transcript();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($transcript);
		$localObjectStorage->detach($transcript);
		$this->fixture->addTranscript($transcript);
		$this->fixture->removeTranscript($transcript);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getTranscripts()
		);
	}
	
	/**
	 * @test
	 */
	public function getChaptersReturnsInitialValueForChapter() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getChapters()
		);
	}

	/**
	 * @test
	 */
	public function setChaptersForObjectStorageContainingChapterSetsChapters() { 
		$chapter = new \Jro\Videoportal\Domain\Model\Chapter();
		$objectStorageHoldingExactlyOneChapters = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneChapters->attach($chapter);
		$this->fixture->setChapters($objectStorageHoldingExactlyOneChapters);

		$this->assertSame(
			$objectStorageHoldingExactlyOneChapters,
			$this->fixture->getChapters()
		);
	}
	
	/**
	 * @test
	 */
	public function addChapterToObjectStorageHoldingChapters() {
		$chapter = new \Jro\Videoportal\Domain\Model\Chapter();
		$objectStorageHoldingExactlyOneChapter = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneChapter->attach($chapter);
		$this->fixture->addChapter($chapter);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneChapter,
			$this->fixture->getChapters()
		);
	}

	/**
	 * @test
	 */
	public function removeChapterFromObjectStorageHoldingChapters() {
		$chapter = new \Jro\Videoportal\Domain\Model\Chapter();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($chapter);
		$localObjectStorage->detach($chapter);
		$this->fixture->addChapter($chapter);
		$this->fixture->removeChapter($chapter);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getChapters()
		);
	}
	
	/**
	 * @test
	 */
	public function getAuthorsReturnsInitialValueForAuthor() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getAuthors()
		);
	}

	/**
	 * @test
	 */
	public function setAuthorsForObjectStorageContainingAuthorSetsAuthors() { 
		$author = new \Jro\Videoportal\Domain\Model\Author();
		$objectStorageHoldingExactlyOneAuthors = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneAuthors->attach($author);
		$this->fixture->setAuthors($objectStorageHoldingExactlyOneAuthors);

		$this->assertSame(
			$objectStorageHoldingExactlyOneAuthors,
			$this->fixture->getAuthors()
		);
	}
	
	/**
	 * @test
	 */
	public function addAuthorToObjectStorageHoldingAuthors() {
		$author = new \Jro\Videoportal\Domain\Model\Author();
		$objectStorageHoldingExactlyOneAuthor = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneAuthor->attach($author);
		$this->fixture->addAuthor($author);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneAuthor,
			$this->fixture->getAuthors()
		);
	}

	/**
	 * @test
	 */
	public function removeAuthorFromObjectStorageHoldingAuthors() {
		$author = new \Jro\Videoportal\Domain\Model\Author();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($author);
		$localObjectStorage->detach($author);
		$this->fixture->addAuthor($author);
		$this->fixture->removeAuthor($author);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getAuthors()
		);
	}
	
	/**
	 * @test
	 */
	public function getCommentsReturnsInitialValueForComment() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getComments()
		);
	}

	/**
	 * @test
	 */
	public function setCommentsForObjectStorageContainingCommentSetsComments() { 
		$comment = new \Jro\Videoportal\Domain\Model\Comment();
		$objectStorageHoldingExactlyOneComments = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneComments->attach($comment);
		$this->fixture->setComments($objectStorageHoldingExactlyOneComments);

		$this->assertSame(
			$objectStorageHoldingExactlyOneComments,
			$this->fixture->getComments()
		);
	}
	
	/**
	 * @test
	 */
	public function addCommentToObjectStorageHoldingComments() {
		$comment = new \Jro\Videoportal\Domain\Model\Comment();
		$objectStorageHoldingExactlyOneComment = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneComment->attach($comment);
		$this->fixture->addComment($comment);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneComment,
			$this->fixture->getComments()
		);
	}

	/**
	 * @test
	 */
	public function removeCommentFromObjectStorageHoldingComments() {
		$comment = new \Jro\Videoportal\Domain\Model\Comment();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($comment);
		$localObjectStorage->detach($comment);
		$this->fixture->addComment($comment);
		$this->fixture->removeComment($comment);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getComments()
		);
	}
	
}
?>