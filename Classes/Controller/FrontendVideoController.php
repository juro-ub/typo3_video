<?php

namespace Jro\Videoportal\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\RedirectResponse;

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
 * *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 *
 *
 * @package videoportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FrontendVideoController extends \Jro\Videoportal\Controller\AbstractController {

    /**
     * videoRepository
     *
     * @var Jro\Videoportal\Domain\Repository\VideoRepository
     */
    protected $videoRepository;

    /**
     * groupRepository
     *
     * @var Jro\Videoportal\Domain\Repository\GroupRepository
     */
    protected $groupRepository;

    /**
     * userRepository
     *
     * @var Jro\Videoportal\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * categoryRepository
     *
     * @var Jro\Videoportal\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * watchcountRepository
     *
     * @var Jro\Videoportal\Domain\Repository\WatchcountRepository
     */
    protected $watchcountRepository;

    /**
     * commentRepository
     *
     * @var Jro\Videoportal\Domain\Repository\CommentRepository
     */
    protected $commentRepository;

    /**
     * @var Jro\Videoportal\Domain\Session\FrontendSessionHandler
     */
    protected $session;

    /**
     * @var Jro\Videoportal\Domain\Service\ArgumentService
     */
    protected $argumentService;

    /**
     * @param Jro\Videoportal\Domain\Repository\CategoryRepository $rep
     */
    public function injectCategoryRepository(\Jro\Videoportal\Domain\Repository\CategoryRepository $rep) {
        $this->categoryRepository = $rep;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\VideoRepository $video
     */
    public function injectVideoRepository(\Jro\Videoportal\Domain\Repository\VideoRepository $video) {
        $this->videoRepository = $video;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\UserRepository $user
     */
    public function injectUserRepository(\Jro\Videoportal\Domain\Repository\UserRepository $user) {
        $this->userRepository = $user;
    }

    /**
     * @param Jro\Videoportal\Domain\Service\ArgumentService $service
     */
    public function injectArgumentService(\Jro\Videoportal\Domain\Service\ArgumentService $service) {
        $this->argumentService = $service;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\CommentRepository $comment
     */
    public function injectCommentRepository(\Jro\Videoportal\Domain\Repository\CommentRepository $comment) {
        $this->commentRepository = $comment;
    }

    /**
     * @param Jro\Videoportal\Domain\Session\FrontendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\FrontendSessionHandler $session) {
        $this->session = $session;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\WatchcountRepository $wc
     */
    public function injectWatchcountRepository(\Jro\Videoportal\Domain\Repository\WatchcountRepository $wc) {
        $this->watchcountRepository = $wc;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\GroupRepository $group
     */
    public function injectGroupRepository(\Jro\Videoportal\Domain\Repository\GroupRepository $group) {
        $this->groupRepository = $group;
    }

    /**
     * initializeAction
     *
     * @return void
     */
    public function initializeAction() {
        parent::initializeAction();
        // Storage Key setzen
        $this->session->setStorageKey(
                'fe_sessiondata'
        );
    }

    /**
     * action search
     * @param string $searchString
     * @return Response
     */
    public function searchAction($searchString = ""): Response {
        $res = array();
        if (strlen($searchString) >= 3) {
            $res = $this->videoRepository->findByStr($searchString, $hidden = false); //no hidden fields
        }
        if (strlen($searchString) < 3)
            $this->addInfo('The search text must have 3 or more characters');
        $this->view->assign('unwatched', $res);

        return $this->htmlResponse();
    }

    /**
     * action list
     * @return Response
     */
    public function listAction(): Response {
        $videos = null;
        $session_catuid = 0;
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $loggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        //stores the watched and unwatched videos
        $watched = array();
        $unwatched = array();
        if ($this->session->get('cat_id'))
            $session_catuid = unserialize($this->session->get('cat_id'));
        if ($session_catuid == FrontendCategoryController::showCommentsCatItem) {
            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('listMyComments', null, 'FrontendComment', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        }
        if ($this->argumentService->hasArgument('tx_videoportal_listcats', 'searchString')) {

            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('search', array('searchString' => $this->argumentService->getArgument('tx_videoportal_listcats', 'searchString')), 'FrontendVideo', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        } else if ($this->argumentService->hasArgument('tx_videoportal_listcats', 'uid') && !$this->argumentService->hasArgument('tx_videoportal_listcats', 'showall')) {
            $catuid = $this->argumentService->getArgument('tx_videoportal_listcats', 'uid');
            if ($catuid == FrontendCategoryController::showCommentsCatItem) {
                $this->redirect('listMyComments', 'FrontendComment', null, null);
            }
            if ($loggedIn) {
                $unwatched = $this->videoRepository->findByCatUid($catuid, $userUid, $watched = false);
                $watched = $this->videoRepository->findByCatUid($catuid, $userUid, $watched = true);
            } else {
                $unwatched = $this->videoRepository->findAllByCatUid($catuid);
            }
        } else if ($this->argumentService->hasArgument('tx_videoportal_listcats', 'showall')) {
            if ($this->argumentService->getArgument('tx_videoportal_listcats', 'showall') == '1') {
                if ($loggedIn) {
                    $unwatched = $this->videoRepository->findAllUnwatchedVideos($userUid);
                    $watched = $this->videoRepository->findAllWatchedVideos($userUid);
                } else {
                    $unwatched = $this->videoRepository->findAll();
                }
            }
        } else if ($session_catuid != FrontendCategoryController::showCommentsCatItem && $session_catuid != FrontendCategoryController::showAllCatItem && $session_catuid > 0) {
            //show videos for the current cat
            if ($loggedIn) {
                $unwatched = $this->videoRepository->findByCatUid($session_catuid, $userUid, $watched = false);
                $watched = $this->videoRepository->findByCatUid($session_catuid, $userUid, $watched = true);
            } else {
                $unwatched = $this->videoRepository->findAllByCatUid($session_catuid);
            }
        } else {
            if ($loggedIn) {
                $unwatched = $this->videoRepository->findAllUnwatchedVideos($userUid);
                $watched = $this->videoRepository->findAllWatchedVideos($userUid);
            } else {
                $unwatched = $this->videoRepository->findAll();
            }
        }
        if ($loggedIn)
            $this->view->assign('member', true); //load the template partial for member
        $this->view->assign('unwatched', $unwatched);
        $this->view->assign('watched', $watched);

        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param integer $videoUid
     * @return Response
     */
    public function showByUidAction($videoUid): Response {
        $video = $this->videoRepository->findByUid($videoUid);
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        if ($video == null) {
            parent::addInfo('No video found!');
            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('list', null, 'FrontendVideo', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        }
        $uri = $uriBuilder
                ->reset()
                ->uriFor('show', array('video' => $video), 'FrontendVideo', 'videoportal', 'Video');
        return new RedirectResponse($uri);
    }

    /**
     * action show
     *
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @param string $jumpToTab
     * @return Response
     */
    public function showAction(\Jro\Videoportal\Domain\Model\Video $video, $jumpToTab = ''): Response {
        if (!$this->isVideoAllowedForUser($video)) {
            $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('notAllowed', array('video' => $video), 'FrontendVideo', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        }
        $this->setVideoAsWatchedIfUserLoggedIn($video);
        $this->incrUserWatchCount($video);
        $relatedVideos = $this->videoRepository->findRelatedVideos($video);
        $c = $video->getWatchCount();
        $video->setWatchCount(++$c);
        $this->videoRepository->update($video);
        $comments = $this->commentRepository->findByVideoId($video->getUid());
        $newComment = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Jro\Videoportal\Domain\Model\Comment');

        $this->view->assign('newComment', $newComment);
        $this->view->assign('video', $video);
        $this->view->assign('comments', $comments);
        $this->view->assign('relatedVideos', $relatedVideos);
        $this->view->assign('jumpToTab', $jumpToTab);
        $this->view->assign('fileadminUrl', '/fileadmin');
        return $this->htmlResponse();
    }

    /**
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    private function setVideoAsWatchedIfUserLoggedIn($video) {
        $userAccess = $GLOBALS['TSFE']->fe_user->groupData['uid'];
        $full = $this->settings['fullGroupUid'];
        $partial = $this->settings['partialGroupUid'];
        $public = $this->settings['publicGroupUid'];
        //get User Id
        $context = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');

        //only partial and full members can see already watched videos
        if (in_array($partial, $userAccess) || in_array($full, $userAccess)) {
            $context = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Context::class);
            if ($context->getPropertyFromAspect('frontend.user', 'isLoggedIn')) {
                $u = $this->userRepository->findByUid($userUid);
                $u->addWatchedVideo($video);
                $this->userRepository->update($u);
            }
        }
    }

    /**
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return void
     */
    private function incrUserWatchCount($video) {
        if (!$this->isVideoAllowedForUser($video)) {
            $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('notAllowed', array('video' => $video), 'FrontendVideo', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        }
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $loggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        if ($loggedIn) {
            $user = $this->userRepository->findByUid($userUid);
            if ($user == null)
                return;
            $counts = $user->getWatchcount();
            $found = false;
            foreach ($counts as $count) {
                if ($count->getVideoId() == $video->getUid()) {
                    $currentCount = $count->getCount();
                    $count->setCount(++$currentCount);
                    $found = true;
                }
            }
            if (!$found) {
                $wc = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Jro\Videoportal\Domain\Model\Watchcount');
                $wc->setVideoId($video->getUid());
                $wc->setCount(1);
                $user->addWatchcount($wc);
            }
            $this->userRepository->update($user);
        }
    }

    /**
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return bool
     */
    private function isVideoAllowedForUser($video): bool {
        $full = $this->settings['fullGroupUid'];
        $partial = $this->settings['partialGroupUid'];
        $public = $this->settings['publicGroupUid'];
        $videoAccess = array();
        $accessibilites = $video->getAccessibilities()->toArray();
        foreach ($accessibilites as $a) {
            array_push($videoAccess, $a->getUid());
        }
        $userAccess = $GLOBALS['TSFE']->fe_user->groupData['uid'];
        //check video is public
        if (in_array($public, $videoAccess) || count($videoAccess) == 0) {
            return true;
        } //check video is partial
        else if (in_array($partial, $videoAccess)) {
            //check if user is partial or full
            if (in_array($partial, $userAccess) || in_array($full, $userAccess)) {
                return true;
            }
        } //check video is full
        else if (in_array($full, $videoAccess)) {
            //check if user is full
            if (in_array($full, $userAccess)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return Response
     */
    public function notAllowedAction(\Jro\Videoportal\Domain\Model\Video $video): Response {
        $relatedVideos = $this->videoRepository->findRelatedVideos($video);
        $this->view->assign('video', $video);
        $this->view->assign('relatedVideos', $relatedVideos);
        return $this->htmlResponse();
    }

    /**
     * switch watch status (watched and unwatched)
     * @param Jro\Videoportal\Domain\Model\Video $video
     * @return Response
     */
    public function switchWatchedStatusAction(\Jro\Videoportal\Domain\Model\Video $video): Response {
        $this->forwardIfNotLoggedIn();
        $context = GeneralUtility::makeInstance(Context::class);
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        $user = $this->userRepository->findByUid($userUid);
        $videos = $user->getWatchedVideos();
        $watched = false;
        foreach ($videos as $v) {
            if ($video->getUid() == $v->getUid()) {
                $watched = true;
            }
        }
        if ($watched)
            $user->removeWatchedVideo($video);
        else
            $user->addWatchedVideo($video);
        $this->userRepository->update($user);
        $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
        $uri = $uriBuilder
                ->reset()
                ->uriFor('list', null, 'FrontendCategory', 'videoportal', 'ListCats');
        return new RedirectResponse($uri);
    }

    /**
     * if logged in return $user else forward to notAllowed
     * @return : Response
     */
    private function forwardIfNotLoggedIn(): Response {
        $context = GeneralUtility::makeInstance(Context::class);
        $loggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
        $userUid = $context->getPropertyFromAspect('frontend.user', 'id');
        if (!$loggedIn) {
            parent::addInfo('This action is only allowed for partial or full members', "");
            $uriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::class);
            $uri = $uriBuilder
                    ->reset()
                    ->uriFor('list', null, 'FrontendVideo', 'videoportal', 'Video');
            return new RedirectResponse($uri);
        } else {
            return $this->htmlResponse();
        }
    }

    /**
     * Removes all session variables
     *
     * @return void
     */
    protected function cleanUpSessionData() {
        
    }

}

?>
