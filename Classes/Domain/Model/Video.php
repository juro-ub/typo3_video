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
class Video extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * pathMp4
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     *
     *
     */
    protected $pathMp4;

    /**
     * pathWebm
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     *
     */
    protected $pathWebm;

    /**
     * pathOgg
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     *
     */
    protected $pathOgg;

    /**
     * time
     *
     * @var DateTime
     *
     */
    protected $crdate;

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 1, "maximum": 50})
     */
    protected $title;

    /**
     * about
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 1, "maximum": 50})
     */
    protected $about;

    /**
     * examRelevant
     *
     * @var boolean
     */
    protected $examRelevant = FALSE;

    /**
     * hidden
     * @var boolean
     */
    protected $hidden = FALSE;

    /**
     * metaKeywords
     *
     * @var string
     */
    protected $metaKeywords;

    /**
     * metaDescription
     *
     * @var string
     */
    protected $metaDescription;

    /**
     * metaTitle
     *
     * @var string
     */
    protected $metaTitle;

    /**
     * watchCount
     *
     * @var integer
     */
    protected $watchCount;

    /**
     * learningObjectives
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 0, "maximum": 500})
     */
    protected $learningObjectives;

    /**
     * thumbnail
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     *
     */
    protected $thumbnail;

    /**
     * targetgroups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Targetgroup>
     */
    protected $targetgroups;

    /**
     * level
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Level>
     */
    protected $levels;

    /**
     * accessibility
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Group>
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $accessibilities;

    /**
     * links
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Link>
     */
    protected $links;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Category>
     */
    protected $categories;

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $files;

    /**
     * transcripts
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     *
     */
    protected $transcripts;

    /**
     * chapters
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     *
     */
    protected $chapters;

    /**
     * authors
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Author>
     */
    protected $authors;

    /**
     * comments
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment>
     */
    protected $comments;

    /**
     * next videos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video>
     */
    protected $nextVideos;

    /**
     * extension videos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video>
     */
    protected $extensionVideos;

    /**
     * extension videos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video>
     */
    protected $requirementVideos;


    /**
     * __construct
     *
     * @return Video
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
        $this->links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->levels = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->accessibilities = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->targetgroups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->files = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->authors = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->comments = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->nextVideos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->requirementVideos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

        $this->extensionVideos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the pathMp4
     *
     * @return  \TYPO3\CMS\Extbase\Domain\Model\FileReference $pathMp4
     */
    public function getPathMp4()
    {
        return $this->pathMp4;
    }

    /**
     * Sets the pathMp4
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $pathMp4
     * @return void
     */
    public function setPathMp4($pathMp4)
    {
        $this->pathMp4 = $pathMp4;
    }

    /**
     * Returns the pathWebm
     *
     * @return  \TYPO3\CMS\Extbase\Domain\Model\FileReference $pathWebm
     */
    public function getPathWebm()
    {
        return $this->pathWebm;
    }

    /**
     * Sets the pathWebm
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $pathWebm
     * @return void
     */
    public function setPathWebm($pathWebm)
    {
        $this->pathWebm = $pathWebm;

    }

    /**
     * Returns the pathOgg
     *
     * @return  \TYPO3\CMS\Extbase\Domain\Model\FileReference $pathOgg
     */
    public function getPathOgg()
    {
        return $this->pathOgg;
    }

    /**
     * Sets the pathOgg
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $pathOgg
     * @return void
     */
    public function setPathOgg($pathOgg)
    {
        $this->pathOgg = $pathOgg;
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
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the about
     *
     * @return string $about
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Sets the about
     *
     * @param string $about
     * @return void
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }


    /**
     * Returns the watchCount
     *
     * @return integer $watchCount
     */
    public function getWatchCount()
    {
        return $this->watchCount;
    }

    /**
     * Sets the watchCount
     *
     * @param integer $watchCount
     * @return void
     */
    public function setWatchCount($watchCount)
    {
        $this->watchCount = $watchCount;
    }

    /**
     * Returns the examRelevant
     *
     * @return boolean $examRelevant
     */
    public function getExamRelevant()
    {
        return $this->examRelevant;
    }

    /**
     * Sets the examRelevant
     *
     * @param boolean $examRelevant
     * @return void
     */
    public function setExamRelevant($examRelevant)
    {
        $this->examRelevant = $examRelevant;
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

    /**
     * Returns the boolean state of examRelevant
     *
     * @return boolean
     */
    public function isExamRelevant()
    {
        return $this->getExamRelevant();
    }

    /**
     * Returns the metaKeywords
     *
     * @return string $metaKeywords
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Sets the metaKeywords
     *
     * @param string $metaKeywords
     * @return void
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * Returns the metaDescription
     *
     * @return string $metaDescription
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Sets the metaDescription
     *
     * @param string $metaDescription
     * @return void
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * Returns the metaTitle
     *
     * @return string $metaTitle
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Sets the metaTitle
     *
     * @param string $metaTitle
     * @return void
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * Returns the learningObjectives
     *
     * @return string $learningObjectives
     */
    public function getLearningObjectives()
    {
        return $this->learningObjectives;
    }

    /**
     * Sets the learningObjectives
     *
     * @param string $learningObjectives
     * @return void
     */
    public function setLearningObjectives($learningObjectives)
    {
        $this->learningObjectives = $learningObjectives;
    }

    /**
     * Returns the thumbnail
     *
     * @return string $thumbnail
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Sets the thumbnail
     *
     * @param string $thumbnail
     * @return void
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * Returns the targetgroup
     *
     * @return @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Targetgroup> $targetgroups
     */
    public function getTargetgroups()
    {
        return $this->targetgroups;
    }

    /**
     * Sets the targetgroups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Targetgroup> $targetgroups
     * @return void
     */
    public function setTargetgroups($targetgroups)
    {
        $this->targetgroups = $targetgroups;
    }

    /**
     * Adds a Targetgroup
     *
     * @param \Jro\Videoportal\Domain\Model\Targetgroup $targetgroup
     * @return void
     */
    public function addTargetgroup(\Jro\Videoportal\Domain\Model\Targetgroup $targetgroup)
    {
        $this->targetgroups->attach($targetgroup);
    }

    /**
     * Removes a Targetgroup
     *
     * @param \Jro\Videoportal\Domain\Model\Targetgroup $targetgroupToRemove The Targetgroup to be removed
     * @return void
     */
    public function removeTargetgroup(\Jro\Videoportal\Domain\Model\Targetgroup $targetgroupToRemove)
    {
        $this->targetgroups->detach($targetgroupToRemove);
    }

    /**
     * Returns the accessibilities
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Group> $accessibilities
     */
    public function getAccessibilities()
    {
        return $this->accessibilities;
    }

    /**
     * Sets the accessibilities
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Group> $accessibilities
     * @return void
     */
    public function setAccessibilities($accessibilities)
    {
        $this->accessibilities = $accessibilities;
    }

    /**
     * Adds a Accessibility
     *
     * @param \Jro\Videoportal\Domain\Model\Group $accessibility
     * @return void
     */
    public function addAccessibility(\Jro\Videoportal\Domain\Model\Group $accessibility)
    {
        $this->accessibilities->attach($accessibility);
    }

    /**
     * Removes a Accessibility
     *
     * @param \Jro\Videoportal\Domain\Model\Group $AccessibilityToRemove The Accessibility to be removed
     * @return void
     */
    public function removeAccessibility(\Jro\Videoportal\Domain\Model\Group $accessibilityToRemove)
    {
        $this->accessibilities->detach($accessibilityToRemove);
    }

    /**
     * Adds a Link
     *
     * @param \Jro\Videoportal\Domain\Model\Link $link
     * @return void
     */
    public function addLink(\Jro\Videoportal\Domain\Model\Link $link)
    {
        $this->links->attach($link);
    }

    /**
     * Removes a Link
     *
     * @param \Jro\Videoportal\Domain\Model\Link $linkToRemove The Link to be removed
     * @return void
     */
    public function removeLink(\Jro\Videoportal\Domain\Model\Link $linkToRemove)
    {
        $this->links->detach($linkToRemove);
    }


    /**
     * Returns the links
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Link> $links
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Sets the links
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Link> $links
     * @return void
     */
    public function setLinks(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $links)
    {
        $this->links = $links;
    }

    /**
     * Adds a Level
     *
     * @param \Jro\Videoportal\Domain\Model\Level $level
     * @return void
     */
    public function addLevel(\Jro\Videoportal\Domain\Model\Level $level)
    {
        $this->levels->attach($level);
    }

    /**
     * Removes a Level
     *
     * @param \Jro\Videoportal\Domain\Model\Level $levelToRemove The Level to be removed
     * @return void
     */
    public function removeLevel(\Jro\Videoportal\Domain\Model\Level $levelToRemove)
    {
        $this->levels->detach($levelToRemove);
    }


    /**
     * Returns the levels
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Level> $levels
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Sets the levels
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Level> $levels
     * @return void
     */
    public function setLevels(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $levels)
    {
        $this->levels = $levels;
    }

    /**
     * Adds a Category
     *
     * @param \Jro\Videoportal\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\Jro\Videoportal\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \Jro\Videoportal\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\Jro\Videoportal\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
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
     * Returns the transcripts
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $transcripts
     */
    public function getTranscripts()
    {
        return $this->transcripts;
    }

    /**
     * Sets the transcripts
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $transcripts
     * @return void
     */
    public function setTranscripts(\TYPO3\CMS\Extbase\Domain\Model\FileReference $transcripts)
    {
        $this->transcripts = $transcripts;
    }


    /**
     * Returns the chapters
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $chapters
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * Sets the chapters
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $chapters
     * @return void
     */
    public function setChapters(\TYPO3\CMS\Extbase\Domain\Model\FileReference $chapters)
    {
        $this->chapters = $chapters;
    }

    /**
     * Adds a Author
     *
     * @param \Jro\Videoportal\Domain\Model\Author $author
     * @return void
     */
    public function addAuthor(\Jro\Videoportal\Domain\Model\Author $author)
    {
        $this->authors->attach($author);
    }

    /**
     * Removes a Author
     *
     * @param \Jro\Videoportal\Domain\Model\Author $authorToRemove The Author to be removed
     * @return void
     */
    public function removeAuthor(\Jro\Videoportal\Domain\Model\Author $authorToRemove)
    {
        $this->authors->detach($authorToRemove);
    }

    /**
     * Returns the authors
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Author> $authors
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Sets the authors
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Author> $authors
     * @return void
     */
    public function setAuthors(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $authors)
    {
        $this->authors = $authors;
    }

    /**
     * Adds a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $comment
     * @return void
     */
    public function addComment(\Jro\Videoportal\Domain\Model\Comment $comment)
    {
        $this->comments->attach($comment);
    }

    /**
     * Removes a Comment
     *
     * @param \Jro\Videoportal\Domain\Model\Comment $commentToRemove The Comment to be removed
     * @return void
     */
    public function removeComment(\Jro\Videoportal\Domain\Model\Comment $commentToRemove)
    {
        $this->comments->detach($commentToRemove);
    }

    /**
     * Returns the comments
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets the comments
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Comment> $comments
     * @return void
     */
    public function setComments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $comments)
    {
        $this->comments = $comments;
    }


    /**
     * Sets the next videos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $videos
     * @return void
     */
    public function setNextVideos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $videos)
    {
        $this->nextVideos = $videos;
    }

    /**
     * Adds a next Videos
     *
     * @param \Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function addNextVideo(\Jro\Videoportal\Domain\Model\Video $video)
    {
        $this->nextVideos->attach($video);
    }

    /**
     * Removes a next Video
     *
     * @param \Jro\Videoportal\Domain\Model\Video $videoToRemove The Videos to be removed
     * @return void
     */
    public function removeNextVideo(\Jro\Videoportal\Domain\Model\Video $videoToRemove)
    {
        $this->nextVideos->detach($videoToRemove);
    }

    /**
     * Returns the videos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $videos
     */
    public function getNextVideos()
    {
        return $this->nextVideos;
    }


    /**
     * Sets the Requirement videos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $videos
     * @return void
     */
    public function setRequirementVideos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $videos)
    {
        $this->requirementVideos = $videos;
    }

    /**
     * Adds a Requirement Videos
     *
     * @param \Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function addRequirementVideo(\Jro\Videoportal\Domain\Model\Video $video)
    {
        $this->requirementVideos->attach($video);
    }

    /**
     * Removes a Requirement Video
     *
     * @param \Jro\Videoportal\Domain\Model\Video $videoToRemove The Videos to be removed
     * @return void
     */
    public function removeRequirementVideo(\Jro\Videoportal\Domain\Model\Video $videoToRemove)
    {
        $this->requirementVideos->detach($videoToRemove);
    }

    /**
     * Returns the videos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $videos
     */
    public function getRequirementVideos()
    {
        return $this->requirementVideos;
    }


    /**
     * Sets the Extension videos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $videos
     * @return void
     */
    public function setExtensionVideos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $videos)
    {
        $this->extensionVideos = $videos;
    }

    /**
     * Adds a extension Videos
     *
     * @param \Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function addExtensionVideo(\Jro\Videoportal\Domain\Model\Video $video)
    {
        $this->extensionVideos->attach($video);
    }

    /**
     * Removes a Requirement Video
     *
     * @param \Jro\Videoportal\Domain\Model\Video $videoToRemove The Videos to be removed
     * @return void
     */
    public function removeExtensionVideo(\Jro\Videoportal\Domain\Model\Video $videoToRemove)
    {
        $this->extensionVideos->detach($videoToRemove);
    }

    /**
     * Returns the videos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Jro\Videoportal\Domain\Model\Video> $videos
     */
    public function getExtensionVideos()
    {
        return $this->extensionVideos;
    }


}

?>