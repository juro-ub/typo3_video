<?php

namespace Jro\Videoportal\Controller;

use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

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
class CommentController extends \Jro\Videoportal\Controller\AbstractController implements LoggerAwareInterface
{

    use LoggerAwareTrait;

    /**
     * @var TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * videoRepository
     *
     * @var Jro\Videoportal\Domain\Repository\VideoRepository
     */
    protected $videoRepository;

    /**
     * commentRepository
     *
     * @var Jro\Videoportal\Domain\Repository\CommentRepository
     */
    protected $commentRepository;

    /**
     * beUserRepository
     *
     * @var Jro\Videoportal\Domain\Repository\BeUserRepository
     */
    protected $beUserRepository;

    /**
     * @var Jro\Videoportal\Domain\Service\ArgumentService
     */
    protected $argumentService;


    /**
     * @param Jro\Videoportal\Domain\Repository\VideoRepository $video
     */
    public function injectVideoRepository(\Jro\Videoportal\Domain\Repository\VideoRepository $video)
    {
        $this->videoRepository = $video;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\CommentRepository $comment
     */
    public function injectCommentRepository(\Jro\Videoportal\Domain\Repository\CommentRepository $comment)
    {
        $this->commentRepository = $comment;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\BeUserRepository $beuser
     */
    public function injectBeUserRepository(\Jro\Videoportal\Domain\Repository\BeUserRepository $beuser)
    {
        $this->beUserRepository = $beuser;
    }

    /**
     * @param Jro\Videoportal\Domain\Service\ArgumentService $service
     */
    public function injectArgumentService(\Jro\Videoportal\Domain\Service\ArgumentService $service)
    {
        $this->argumentService = $service;
    }

    /**
     * @param TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $pm
     */
    public function injectPersistenceManager(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $pm)
    {
        $this->persistenceManager = $pm;
    }

    /**
     * initializeAction
     *
     * @return void
     */
    public function initializeAction()
    {
        parent::initializeAction();
        $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(__CLASS__);
    }

    /**
     * action listByVideoId
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @param string $searchString
     * @return void
     */
    public function listByVideoAction($video, $searchString = "")
    {
        if (strlen($searchString) > 0) {
            $comments = $this->commentRepository->findByStr($searchString, $video);
        } else {

            $comments = $this->commentRepository->findByStr($searchString, $video);
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($comments);exit;
        $this->view->assign('searchString', $searchString);
        $this->view->assign('video', $video);
        $this->view->assign('comments', $comments);
    }

    /**
     * action list
     * @param string $searchString
     * @return void
     */
    public function listAction($searchString = "")
    {
        if (strlen($searchString) > 0) {
            $comments = $this->commentRepository->findByStr($searchString);
        } else {
            $comments = $this->commentRepository->findAll();
        }

        $this->view->assign('searchString', $searchString);
        $this->view->assign('comments', $comments);
    }

    /**
     * action show
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function showAction(\Jro\Videoportal\Domain\Model\Comment $comment, $video = null)
    {
        $beuser = $GLOBALS['BE_USER']->user;
        if ($beuser != null && is_array($beuser)) {
            $uid = $beuser['uid'];
            $user = $this->beUserRepository->findByUid($uid);
            if ($user != null) {
                $user->addWatchedComment($comment);
                $this->beUserRepository->update($user);
            }
        }
        $this->view->assign('comment', $comment);
        $this->view->assign('video', $video);
    }

    /**
     * action new
     *
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param integer $parentCommentUid
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @IgnoreValidation("newComment")
     * @return void
     */
    public function newAction(\Jro\Videoportal\Domain\Model\Comment $newComment = NULL, $parentCommentUid = 0, $video = null)
    {
        if ($newComment == NULL) {
            // workaround for fluid bug ##5636
            $newComment = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Jro\Videoportal\Domain\Model\Comment');
        }

        //mark parent as watched
        $parent = $this->commentRepository->findByUid($parentCommentUid);
        $beuser = $GLOBALS['BE_USER']->user;
        if ($beuser != null && is_array($beuser) && $parent != null) {
            $uid = $beuser['uid'];
            $user = $this->beUserRepository->findByUid($uid);
            if ($user != null) {
                $user->addWatchedComment($parent);
                $this->beUserRepository->update($user);
            }
        }
        $files = array();
        parent::fillArray($files);
        $this->view->assign('newComment', $newComment);
        $this->view->assign('files', $files);
        $this->view->assign('video', $video);
        $this->view->assign('parentCommentUid', $parentCommentUid);
    }

    /**
     * action create
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param array $files
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator")
     * @return void
     */
    public function createAction(\Jro\Videoportal\Domain\Model\Comment $newComment, $files, $parentCommentUid = 0)
    {
        //find parent comment
        $parent = $this->commentRepository->findByUid($parentCommentUid);
        if ($parent != null) {
            $parent->addChild($newComment);
            $this->commentRepository->update($parent);
        } else {
            $this->commentRepository->add($newComment);
        }
        //add comment to user
        $beuser = $GLOBALS['BE_USER']->user;
        if ($beuser != null && is_array($beuser) && $newComment != null) {
            $uid = $beuser['uid'];
            $user = $this->beUserRepository->findByUid($uid);
            if ($user != null) {
                $user->addWatchedComment($newComment);
                $user->addMyComment($newComment);
                $this->beUserRepository->update($user);
            }
        }

        $this->persistenceManager->persistAll();
        $uidNew = $newComment->getUid();

        //add files for the comment
        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != '1') {
                $sysFileCreate = $this->commentRepository->myFileOperationsFal
                ($file['name'], $file['type'], $file['size'], $uidNew, "files");
            }
            if ($file['deleted'] == '1') {
                $this->commentRepository->removeFile($file['uid']);
            }
        }

        parent::addInfo('Your new Comment was created.');

        //determine the redirection
        if ($this->argumentService->hasArgument('tx_videoportal_web_videoportalvideoportalbackendmodul', 'video')) {
            $this->redirect('listByVideo', 'Comment', Null, array('video' => $this->argumentService->getArgument('tx_videoportal_web_videoportalvideoportalbackendmodul', 'video')));
        } else {
            $this->redirect('list');
        }
    }

    /**
     * action edit
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function editAction(\Jro\Videoportal\Domain\Model\Comment $comment, $video = null)
    {
        //create file array
        $files = array();
        if ($comment->getFiles() != null) {
            $filesComment = $comment->getFiles()->toArray();
            foreach ($filesComment as $f) {
                array_push($files, array('name' => $f->getOriginalResource()
                    ->getOriginalFile()->getName(), 'uid' => $f->getOriginalResource()
                    ->getUid()));
            }
        }

        //mark comment as watched
        $beuser = $GLOBALS['BE_USER']->user;
        if ($beuser != null && is_array($beuser) && $comment != null) {
            $uid = $beuser['uid'];
            $user = $this->beUserRepository->findByUid($uid);
            if ($user != null) {
                $user->addWatchedComment($comment);
                $this->beUserRepository->update($user);
            }
        }

        parent::fillArray($files);
        $this->view->assign('comment', $comment);
        $this->view->assign('files', $files);
        $this->view->assign('video', $video);
    }

    /**
     * action update
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param array $files
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator")
     * @return void
     */
    public function updateAction(\Jro\Videoportal\Domain\Model\Comment $comment, $files)
    {
        //update files
        $uidNew = $comment->getUid();
        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != '1') {
                $sysFileCreate = $this->commentRepository->myFileOperationsFal
                ($file['name'], $file['type'], $file['size'], $uidNew, "files");
            }
            if ($file['deleted'] == '1') {
                $this->commentRepository->removeFile($file['uid']);
            }
        }
        //update comment
        $this->commentRepository->update($comment);
        parent::addInfo('Your Comment was updated.');
        //determine redirection
        if ($this->argumentService->hasArgument('tx_videoportal_web_videoportalvideoportalbackendmodul', 'video')) {
            $this->redirect('listByVideo', 'Comment', Null, array('video' => $this->argumentService->getArgument('tx_videoportal_web_videoportalvideoportalbackendmodul', 'video')));
        } else {
            $this->redirect('list');
        }
    }

    /**
     * action setCommentAsWatchedAjax
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function setCommentAsWatchedAjaxAction(ServerRequestInterface $request) : ResponseInterface
    {
        //mark comment as watched
        $uid = $request->getQueryParams()['uid'] ?? null;
        if($uid != null){
            $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, "setCommentAsWatchedAjaxAction comment uid:".$uid,
                array($uid)
            );
            $comment = $this->commentRepository->findByUid($uid);
            $beuser = $GLOBALS['BE_USER']->user;
            if ($beuser != null && is_array($beuser) && $comment != null) {
                $uidBe = $beuser['uid'];
                $user = $this->beUserRepository->findByUid($uidBe);
                if ($user != null) {
                    $user->addWatchedComment($comment);
                    $this->beUserRepository->update($user);
                    $this->persistenceManager->persistAll();
                }
                return new Response(json_encode(['result' => "Ok for comment Uid: ".$uid." Be User:".$uidBe]), 200, ['Content-Type' => 'application/json; charset=utf-8']);
            }
            return new Response(json_encode(['result' => "Not logged in"]), 500, ['Content-Type' => 'application/json; charset=utf-8']);
        }
        return new Response(json_encode(['result' => "Comment Uid not set"]), 500, ['Content-Type' => 'application/json; charset=utf-8']);
    }

    /**
     * action delete
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function deleteAction(\Jro\Videoportal\Domain\Model\Comment $comment, $video = null)
    {
        $this->commentRepository->remove($comment);
        parent::addInfo('Your Comment was removed.');
        if ($video != null) {
            $this->redirect('listByVideo', 'Comment', Null, array('video' => $this->argumentService->getArgument('tx_videoportal_web_videoportalvideoportalbackendmodul', 'video')));
        } else {
            $this->redirect('list');
        }
    }

}

?>