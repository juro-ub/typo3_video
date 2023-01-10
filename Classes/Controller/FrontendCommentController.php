<?php
namespace Jro\Videoportal\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
     * @return void
     */
    public function listAction()
    {
        $comments = $this->commentRepository->findAll();
        $files = array();
        parent::fillArray($files);
        $this->view->assign('files', $files);
        $this->view->assign('comments', $comments);
    }

    /**
     * user action listMyComments
     *
     * @return void
     */
    public function listMyCommentsAction()
    {
        $this->forwardIfNotLoggedIn();
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $user = $this->userRepository->findByUid($userUid);
        if ($user != null) {
            $comments = $user->getMyComments();
        }
        $uids = array();
        foreach ($comments as $c) {
            array_push($uids, $c->getUid());
        }
        $comments = $this->commentRepository->findByUids($uids);
        $this->view->assign('comments', $comments);
        $this->view->assign('listOption', 'myquestions');
    }

    /**
     * user action listObservedComments
     *
     * @return void
     */
    public function listObservedCommentsAction()
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
    }

    /**
     * action show
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @return void
     */
    public function showAction(\Jro\Videoportal\Domain\Model\Comment $comment = null)
    {
        $this->view->assign('comment', $comment);
    }

    /**
     * action new for new template
     *
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newComment")
     * @return void
     */
    public function newAction(\Jro\Videoportal\Domain\Model\Comment $newComment = null, \Jro\Videoportal\Domain\Model\Video $video = null, $parentCommentUid = 0)
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
    }

    /**
     * action newMyComments for newMyComment Template
     *
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newComment")
     * @return void
     */
    public function newMyCommentAction(\Jro\Videoportal\Domain\Model\Comment $newComment = null, $parentCommentUid = 0)
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
    }

    /**
     * action create
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param array $files
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator")
     * @return void
     */
    public function createAction(\Jro\Videoportal\Domain\Model\Comment $newComment, $files, \Jro\Videoportal\Domain\Model\Video $video = null, $parentCommentUid = 0)
    {
        $this->forwardIfNotLoggedIn();
        if ($submit == "Cancel") {
            $this->redirect('show', 'FrontendVideo', null, array("video" => ""));
        }
        $this->createCommentAndFiles($parentCommentUid, $newComment, $files);
        $this->addCommentToUser($newComment);
        $this->addCommentToVideo($newComment, $video, $parentCommentUid);

        parent::addInfo('Your new Comment was created.');
        $this->redirect('show', 'FrontendVideo', null, array('video' => $video, 'jumpToTab' => 'videoTabPaneQA'));
    }


    /**
     * action createMyComment
     * @param Jro\Videoportal\Domain\Model\Comment $newComment
     * @param array $files
     * @param integer $parentCommentUid
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="files", validator="Jro\Videoportal\Validation\Validator\FrontendFilesValidator")
     * @return void
     */
    public function createMyCommentAction(\Jro\Videoportal\Domain\Model\Comment $newComment, $files, $parentCommentUid = 0)
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
        $this->redirectToUri($uri);
    }

    /**
     * action switchObserveStatus
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    public function switchObserveStatusAction(\Jro\Videoportal\Domain\Model\Comment $comment, \Jro\Videoportal\Domain\Model\Video $video)
    {
        $this->forwardIfNotLoggedIn();
        $this->switchObservedStatus($comment);
        parent::addInfo('Status for Comment was updated.');
        $this->redirect('show', 'FrontendVideo', null, array('video' => $video, 'jumpToTab' => 'videoTabPaneQA'));
    }


    /**
     * action switchObserveStatus MyCommentsTemplate
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @return void
     */
    public function switchObserveStatusMyCommentsAction(\Jro\Videoportal\Domain\Model\Comment $comment)
    {
        $this->forwardIfNotLoggedIn();
        $this->switchObservedStatus($comment);
        parent::addInfo('Status for Comment was updated.');
        $this->redirect('listMyComments');
    }

    /**
     * action edit
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("comment")
     * @return void
     */
    public function editAction(\Jro\Videoportal\Domain\Model\Comment $comment)
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
        $this->redirectToUri($uri);
    }

    /**
     * action delete
     *
     * @param Jro\Videoportal\Domain\Model\Comment $comment
     * @return void
     */
    public function deleteAction(\Jro\Videoportal\Domain\Model\Comment $comment)
    {
        $this->commentRepository->remove($comment);
        parent::addInfo('Your Comment was removed.');
        $this->redirect('list');
    }

    /**
     * checks user login
     * @return void
     */
    private function forwardIfNotLoggedIn()
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $loggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        if (!$loggedIn) {
            parent::addInfo('This action is only allowed for partial or full members');
            $this->redirect('notAllowed');
        } else {
            return $this->userRepository->findByUid($userUid);
        }
    }

    /**
     * @return void
     */
    public function notAllowedAction()
    {
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
