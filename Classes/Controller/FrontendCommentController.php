<?php
namespace Jro\Videoportal\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\RedirectResponse;
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
class FrontendCommentController extends \Jro\Videoportal\Controller\AbstractController
{
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
     * userRepository
     *
     * @var Jro\Videoportal\Domain\Repository\UserRepository
     */
    protected $userRepository;


    /**
     * commentRepository
     *
     * @var Jro\Videoportal\Domain\Repository\CommentRepository
     */
    protected $commentRepository;

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
     * @param Jro\Videoportal\Domain\Repository\UserRepository $user
     */
    public function injectUserRepository(\Jro\Videoportal\Domain\Repository\UserRepository $user)
    {
        $this->userRepository = $user;
    }

    /**
     * @param TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $pm
     */
    public function injectPersistenceManager(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $pm)
    {
        $this->persistenceManager = $pm;
    }

    /**
     * action list
     *
     * @return Response
     */
    public function listAction() : Response
    {
        $comments = $this->commentRepository->findAll();
        $files = array();
        parent::fillArray($files);
        $this->view->assign('files', $files);
        $this->view->assign('comments', $comments);
        
        return $this->htmlResponse();
    }

    /**
     * user action listMyComments
     *
     * @return Response
     */
    public function listMyCommentsAction() : Response
    {
        $this->forwardIfNotLoggedIn();
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $user = $this->userRepository->findByUid($userUid);
        if ($user != null) {
            $comments = $user->getMyComments();
        }
        $uids = array();
        if (isset($comments)) {
            foreach ($comments as $c) {
                array_push($uids, $c->getUid());
            }
        }
        $comments = $this->commentRepository->findByUids($uids);
        $this->view->assign('comments', $comments);
        $this->view->assign('listOption', 'myquestions');
        
        return $this->htmlResponse();
    }

    /**
     * user action listObservedComments
     *
     * @return Response
     */
    public function listObservedCommentsAction() : Response
    {
        $this->forwardIfNotLoggedIn();
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $user = $this->userRepository->findByUid($userUid);
        if ($user != null) {
            $comments = $user->getObservedComments();
        }
        $uids = array();
        foreach ($comments as $c) {
            array_push($uids, $c->getUid());
        }
        $comments = $this->commentRepository->findByUids($uids);
        $this->view->assign('comments', $comments);
        
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @return Response
     */
    public function showAction(\Jro\Videoportal\Domain\Model\Comment $comment = null) : Response
    {
        $this->view->assign('comment', $comment);
        
        return $this->htmlResponse();
    }

    /**
     * action new for new template
     *
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newComment")
     * @return Response
     */
    public function newAction(\Jro\Videoportal\Domain\Model\Comment $newComment = null, \Jro\Videoportal\Domain\Model\Video $video = null, $parentCommentUid = 0) : Response
    {
        if ($newComment == null) {
            // workaround for fluid bug ##5636
            $newComment = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Jro\Videoportal\Domain\Model\Comment');
        }
        $files = array();
        parent::fillArray($files);
        $this->view->assign('newComment', $newComment);
        $this->view->assign('files', $files);
        $this->view->assign('parentCommentUid', $parentCommentUid);
        $this->view->assign('video', $video);
        
        return $this->htmlResponse();
    }

    /**
     * action newMyComments for newMyComment Template
     *
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newComment")
     * @return Response
     */
    public function newMyCommentAction(\Jro\Videoportal\Domain\Model\Comment $newComment = null, $parentCommentUid = 0) : Response
    {
        if ($newComment == null) {
            // workaround for fluid bug ##5636
            $newComment = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Jro\Videoportal\Domain\Model\Comment');
        }
        $files = array();
        parent::fillArray($files);
        $this->view->assign('newComment', $newComment);
        $this->view->assign('files', $files);
        $this->view->assign('parentCommentUid', $parentCommentUid);
        
        return $this->htmlResponse();
    }

    /**
     * action create
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param array $files
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator", options={"types": "pdf,zip,rar,7zip,jpg,png,gif,jpeg", "maxsize": 10000000})
     * @return Response
     */
    public function createAction(\Jro\Videoportal\Domain\Model\Comment $newComment, array $files, \Jro\Videoportal\Domain\Model\Video $video = null, int $parentCommentUid = 0) : Response
    {
        $this->forwardIfNotLoggedIn();
        if ($submit == "Cancel") {
            $this->redirect('show', 'FrontendVideo', null, array("video" => ""));
        }
        $this->createCommentAndFiles($parentCommentUid, $newComment, $files);
        $this->addCommentToUser($newComment);
        $this->addCommentToVideo($newComment, $video, $parentCommentUid);

        parent::addInfo('Your new Comment was created.');
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        $uri = $uriBuilder
                ->reset()
                ->uriFor('show', array('video' => $video, 'jumpToTab' => 'videoTabPaneQA'), 'FrontendVideo', 'videoportal', 'Video');
        return new RedirectResponse($uri);
    }


    /** 
     * action createMyComment
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param array $files
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator", options={"types": "pdf,zip,rar,7zip,jpg,png,gif,jpeg", "maxsize": 10000000})
     * @return Response
     */
    public function createMyCommentAction(\Jro\Videoportal\Domain\Model\Comment $newComment, array $files, int $parentCommentUid = 0) : Response
    {
        $this->forwardIfNotLoggedIn();
        $this->createCommentAndFiles($parentCommentUid, $newComment, $files);
        $this->addCommentToUser($newComment);
        parent::addInfo('Your new Comment was created.');
        $uriBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Backend\Routing\UriBuilder');
        $uriBuilder->reset();
        //arguments for the plugins
        $uriBuilder->setArguments(array(
            'tx_videoportal_listcats' => array(
                'action' => 'list',
                'uid' => '999999998',
                'level_id' => '0'
            ),
            'tx_videoportal_video' => array(
                'action' => 'listMyComments',
                'controller' => 'FrontendComment'
            )
        ));
        $uri = $uriBuilder->build();
        return new RedirectResponse($uri);
    }

    /**
     * action switchObserveStatus
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return Response
     */
    public function switchObserveStatusAction(\Jro\Videoportal\Domain\Model\Comment $comment, \Jro\Videoportal\Domain\Model\Video $video) : Response
    {
        $this->forwardIfNotLoggedIn();
        $this->switchObservedStatus($comment);
        parent::addInfo('Status for Comment was updated.');
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        $uri = $uriBuilder
                ->reset()
                ->uriFor('show', array('video' => $video, 'jumpToTab' => 'videoTabPaneQA'), 'FrontendVideo', 'videoportal', 'Video');
        return new RedirectResponse($uri);
    }


    /**
     * action switchObserveStatus MyCommentsTemplate
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @return Response
     */
    public function switchObserveStatusMyCommentsAction(\Jro\Videoportal\Domain\Model\Comment $comment) : Response
    {
        $this->forwardIfNotLoggedIn();
        $this->switchObservedStatus($comment);
        parent::addInfo('Status for Comment was updated.');
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        $uri = $uriBuilder
                ->reset()
                ->uriFor('listMyComments', null, 'FrontendComment', 'videoportal', 'Video');
        return new RedirectResponse($uri);
    }

    /**
     * action edit
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("comment")
     * @return Response
     */
    public function editAction(\Jro\Videoportal\Domain\Model\Comment $comment) : Response
    {
        //generate file array for tpl
        $files = array();
        if ($comment->getFiles() != null) {
            $filesComment = $comment->getFiles()->toArray();
            foreach ($filesComment as $f) {
                array_push($files, array('name' => $f->getOriginalResource()
                    ->getOriginalFile()->getName(), 'uid' => $f->getOriginalResource()
                    ->getUid()));
            }
        }
        parent::fillArray($files);
        $this->view->assign('comment', $comment);
        $this->view->assign('files', $files);
        
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param array $files
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator", options={"types": "pdf,zip,rar,7zip,jpg,png,gif,jpeg", "maxsize": 10000000})
     * @return Response
     */
    public function updateAction(\Jro\Videoportal\Domain\Model\Comment $comment, array $files) : Response
    {
        //update files
        $uidNew = $comment->getUid();
        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != '1') {
                $sysFileCreate = $this->commentRepository->myFileOperationsFal($file['name'], $file['type'], $file['size'], $uidNew, "files");
            }
            if ($file['deleted'] == '1') {
                $this->commentRepository->removeFile($file['uid']);
            }
        }
        $this->commentRepository->update($comment);
        parent::addInfo('Your Comment was updated.');
        $uriBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\TYPO3\CMS\Backend\Routing\UriBuilder');
        $uriBuilder->reset();
        $uriBuilder->setArguments(array(
            'tx_videoportal_listcats' => array(
                'action' => 'list',
                'uid' => '999999998',
                'level_id' => '0'
            ),
            'tx_videoportal_video' => array(
                'action' => 'listMyComments',
                'controller' => 'FrontendComment'
            )
        ));
        $uri = $uriBuilder->build();
        return new RedirectResponse($uri);
    }

    /**
     * action delete
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @return Response
     */
    public function deleteAction(\Jro\Videoportal\Domain\Model\Comment $comment) : Response
    {
        $this->commentRepository->remove($comment);
        parent::addInfo('Your Comment was removed.');
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        $uri = $uriBuilder
                ->reset()
                ->uriFor('list', null, 'FrontendComment', 'videoportal', 'Video');
        return new RedirectResponse($uri);
    }

    /**
     * checks user login
     * @return void
     */
    private function forwardIfNotLoggedIn() : Response
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $loggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        if (!$loggedIn) {
            parent::addInfo('This action is only allowed for partial or full members');
            $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('notAllowed', null, 'FrontendComment', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        } else {
            return $this->userRepository->findByUid($userUid);
        }
    }

    /**
     * @return Response
     */
    public function notAllowedAction() : Response
    {
        return $this->htmlResponse();
    }

    /**
     * create comment and files
     * @return void
     */
    private function createCommentAndFiles($parentCommentUid, $newComment, $files)
    {
        $parent = $this->commentRepository->findByUid($parentCommentUid);
        if ($parent != null) {
            $parent->addChild($newComment);
            $this->commentRepository->update($parent);
        } else {
            $this->commentRepository->add($newComment);
        }
        $this->persistenceManager->persistAll();

        $uidNew = $newComment->getUid();

        foreach ($files as $file) {
            if ($file['name'] && $file['tmp_name'] && $file['deleted'] != '1') {
                $sysFileCreate = $this->commentRepository->myFileOperationsFal($file['name'], $file['type'], $file['size'], $uidNew, "files");
            }
            if ($file['deleted'] == '1') {
                $this->commentRepository->removeFile($file['uid']);
            }
        }
    }

    /**
     * add comment to logged in user
     * @return void
     */
    private function addCommentToUser($newComment)
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $loggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        if ($loggedIn) {
            $user = $this->userRepository->findByUid($userUid);
            if ($user != null) {
                $user->addMyComment($newComment);
                $this->userRepository->update($user);
            }
        }
    }

    /**
     * add comment to a video
     * @return void
     */
    private function addCommentToVideo($newComment, $video, $parentCommentUid)
    {
        $parent = $this->commentRepository->findByUid($parentCommentUid);
        //add comment to video
        $video = $this->videoRepository->findByUid($video->getUid());
        if ($video != null && $parent == null) {
            $video->addComment($newComment);
            $this->videoRepository->update($video);
        }
    }

    /**
     * switch observed status for the user
     * @return void
     */
    private function switchObservedStatus($comment)
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $user = $this->userRepository->findByUid($userUid);
        $comments = $user->getObservedComments();
        $observed = false;
        foreach ($comments as $c) {
            if ($comment->getUid() == $c->getUid()) {
                $observed = true;
            }
        }
        if ($observed) {
            $user->removeObservedComment($comment);
        } else {
            $user->addObservedComment($comment);
        }
        $this->userRepository->update($user);
    }
}
