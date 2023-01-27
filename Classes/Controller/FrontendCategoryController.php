<?php

namespace Jro\Videoportal\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface\ResponseInterface;
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
class FrontendCategoryController extends \Jro\Videoportal\Controller\AbstractController
{
    #Ids of static Category Items that are not handled by the Video Category Plugin
    const showCommentsCatItem = 999999998;
    const showAllCatItem = 999999999;
    /**
     * categoryRepository
     *
     * @var Jro\Videoportal\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * videoRepository
     *
     * @var Jro\Videoportal\Domain\Repository\VideoRepository
     */
    protected $videoRepository;

    /**
     * @var Jro\Videoportal\Domain\Session\FrontendSessionHandler
     */
    protected $session;

    /**
     * @param Jro\Videoportal\Domain\Repository\CategoryRepository $rep
     */
    public function injectCategoryRepository(\Jro\Videoportal\Domain\Repository\CategoryRepository $rep)
    {
        $this->categoryRepository = $rep;
    }

    /**
     * @param Jro\Videoportal\Domain\Repository\VideoRepository $video
     */
    public function injectVideoRepository(\Jro\Videoportal\Domain\Repository\VideoRepository $video)
    {
        $this->videoRepository = $video;
    }

    /**
     * @param Jro\Videoportal\Domain\Session\FrontendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\FrontendSessionHandler $session)
    {
        $this->session = $session;
    }

    /**
     * initializeAction
     *
     * @return void
     */
    public function initializeAction()
    {
        parent::initializeAction();
        // Storage Key setzen
        $this->session->setStorageKey(
            'fe_sessiondata'
        );

        //clear the category controller session data if user perform a search
        if ($this->request->hasArgument('searchString')) {
            $this->cleanUpSessionData();
        }
    }

    /**
     * checks if the category uid is in the last level
     * @param integer $uid
     * @param integer $level_id
     * @return boolean
     */
    private function isUidInLastLevel($uid, $level_id)
    {
        $levels = unserialize($this->session->get('levels'));
        $i = count($levels['levels']) - 1;
        foreach ($levels['levels'][$i] as $cat) {
            if ($cat->getUid() == $uid && $i == $level_id) {
                return true;
            }
        }
        return false;
    }

    /**
     * remove all active category uids in the specified level
     * @param integer $level_id
     * @return void
     */
    private function removeStatusActiveInLevel($level_id)
    {
        $active = unserialize($this->session->get('activeUids'));
        for ($i = 0; $i < count($active); $i++) {
            if ($active[$i]['level_id'] == $level_id) {
                unset($active[$i]);
            }
        }
        $active = array_values($active);
        $this->session->store('activeUids', serialize($active));
    }

    /**
     * set a category uid to status active in the specified level
     * @param int $uid
     * @param int $level_id
     * @return void
     */
    private function setStatusActiveInLevel($uid, $level_id)
    {
        if ($this->session->get('activeUids')) {
            $active = unserialize($this->session->get('activeUids'));
        } else {
            $active = array();
        }
        $found = false;
        foreach ($active as &$c) {
            if ($c['level_id'] == $level_id) {
                $found = true;
                $c['uid'] = $uid;
            }
        }
        if ($found == false) {
            array_push($active, array('level_id' => $level_id, 'uid' => $uid));
        }
        $this->session->store('activeUids', serialize($active));
    }

    /**
     * remove obsolete levels
     * @param int $uid
     * @param int $level_id
     * @return void
     */
    private function removeObsoleteLevels($uid, $level_id)
    {
        $levels = unserialize($this->session->get('levels'));
        $orig = $levels;

        for ($i = count($levels['levels']); $i >= 1; --$i) {
            if ($level_id < $i) {
                $this->removeStatusActiveInLevel($i);
                unset($levels['levels'][$i]);
            }
        }
        $levels['levels'] = array_values($levels['levels']);
        $this->session->store('levels', serialize(array('levels' => $levels['levels'])));
    }


    /**
     * action list
     * @param int $uid
     * @param int $level_id
     * @param string $searchString
     * @param string $submit
     * @param string $showall
     * @return ResponseInterface
     */
    public function listAction($uid = -1, $level_id = -1, $searchString = "", $submit = "", $showall = "0") : ResponseInterface
    {
        $levels = array();
        if ((!$this->session->get('cat_id')) || $uid == self::showAllCatItem || $uid == self::showCommentsCatItem) {
            $this->cleanUpSessionData();
            $levels = array('levels' => array());
            $categories = $this->categoryRepository->findAll();
            $categories = $this->removeDuplicatedCats($categories);
            array_push($levels['levels'], $categories);
            $this->session->store('levels', serialize(array('levels' => $levels['levels'])));
            $this->setStatusActiveInLevel($uid, $level_id);
        } elseif ($uid == -1 && $this->session->get('cat_id')) {
            $uid = unserialize($this->session->get('cat_id'));
            $level_id = unserialize($this->session->get('level_id'));
        }
        if ($uid >= 0) {
            $this->session->store('cat_id', serialize($uid));
            $this->session->store('level_id', serialize($level_id));
            $cat = $this->categoryRepository->findByUid($uid);
            if ($this->isUidInLastLevel($uid, $level_id)) {
                $levels = unserialize($this->session->get('levels'));
                if (count($cat->getParent()) > 0) {
                    array_push($levels['levels'], $cat->getParent());
                }
                $this->session->store('levels', serialize(array('levels' => $levels['levels'])));
            } else {
                $this->removeObsoleteLevels($uid, $level_id);
                $levels = unserialize($this->session->get('levels'));
                if (isset($cat) && $cat != null && count($cat->getParent()) > 0) {
                    array_push($levels['levels'], $cat->getParent());
                }
                $this->session->store('levels', serialize(array('levels' => $levels['levels'])));
            }
            $this->setStatusActiveInLevel($uid, $level_id);
        }

        //info for login box partial
        $context = GeneralUtility::makeInstance(Context::class);
        $name = $context->getPropertyFromAspect('frontend.user', 'username');
        $pid = $this->settings['feloginPid'];
        $this->view->assign('username', $name);
        $this->view->assign('loginPid', $pid);
        //category data
        $this->view->assign('levels', $levels);
        $this->view->assign('uid', $uid);
        $this->view->assign('level_id', $level_id);
        $this->view->assign('searchString', $searchString);
        $this->view->assign('countAll', $this->videoRepository->countAll());

        $this->view->assign('showAllId', self::showAllCatItem);
        $this->view->assign('showCommentsId', self::showCommentsCatItem);
        
        return $this->htmlResponse();

    }


    /**
     * Remove obsolete categories from the array
     *
     * @return array $newStructure
     */
    private function removeDuplicatedCats($categories)
    {
        $all = $this->categoryRepository->findAll();
        $newStructure = array();
        $categories = $categories->toArray();
        $c = array_shift($categories);
        while ($c != null) {
            if ($c != null && $this->countParentsByUid($c, $all) == 0) {
                array_push($newStructure, $c);
            }
            $c = array_shift($categories);
        }
        return $newStructure;
    }

    /**
     * Returns the number of parent from $cat
     *
     * @return int
     */
    private function countParentsByUid($cat, $categories)
    {
        $count = 0;
        foreach ($categories as $c1) {
            foreach ($c1->getParent() as $p) {
                if ($p->getUid() == $cat->getUid()) {
                    $count++;
                }
            }
        }
        return $count;
    }

    protected function cleanUpSessionData()
    {
        $this->session->delete('levels');
        $this->session->delete('cat_id');
        $this->session->delete('level_id');
        $this->session->delete('activeUids');
    }
}
