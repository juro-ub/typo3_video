<?php

namespace Jro\Videoportal\Controller;
use TYPO3\CMS\Core\Http\Response;
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
class CategoryController extends \Jro\Videoportal\Controller\AbstractController
{

    /**
     * @var Jro\Videoportal\Domain\Repository\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var Jro\Videoportal\Domain\Session\BackendSessionHandler
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
     * @param Jro\Videoportal\Domain\Session\BackendSessionHandler $session
     */
    public function injectSession(\Jro\Videoportal\Domain\Session\BackendSessionHandler $session)
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
            $this->request->getControllerExtensionName() .
            $this->request->getPluginName()
        );
    }

    /**
     * action list
     *
     * @return Response
     */
    public function listAction() : Response
    {
        $this->cleanUpSessionData();
        $categories = $this->categoryRepository->findAll();
        $categories = $this->removeDuplicatedCats($categories);
        $this->view->assign('categories', $categories);
        
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param Jro\Videoportal\Domain\Model\Category $category
     * @return Response
     */
    public function showAction(\Jro\Videoportal\Domain\Model\Category $category) : Response
    {
        $categories = $this->categoryRepository->findAll();
        $pids = array();
        foreach ($category->getParent() as $parent) {
            array_push($pids, $parent->getUid());
        }
        $categories = $this->removeDuplicatedCats($categories);
        $this->view->assign('categories', $categories);
        $this->view->assign('pids', $pids);
        $this->view->assign('category', $category);
        
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @param Jro\Videoportal\Domain\Model\Category $newCategory
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("newCategory")
     * @return Response
     */
    public function newAction(\Jro\Videoportal\Domain\Model\Category $newCategory = null): Response
    {
        if ($newCategory == null) { // workaround for fluid bug ##5636
            $newCategory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Jro\Videoportal\Domain\Model\Category');
        }
        $categories = $this->categoryRepository->findAll();
        $categories = $this->removeDuplicatedCats($categories);
        $this->view->assign('newCategory', $newCategory);
        $this->view->assign('categories', $categories);
        $pids = array();
        if ($this->session->get('pids')) {
            $pids = unserialize($this->session->get('pids'));
        }
        $this->view->assign('pids', $pids);
        
        return $this->htmlResponse();
    }

    /**
     * action create
     * @param Jro\Videoportal\Domain\Model\Category $newCategory
     * @param array $pids
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="pids", validator="Jro\Videoportal\Validation\Validator\ParentCategoryValidator")
     * @return Response
     */
    public function createAction(\Jro\Videoportal\Domain\Model\Category $newCategory, array $pids) : Response
    {
        //set parent categories
        $ischild = false;
        foreach ($pids as $pid) {
            if ($pid > 0) {
                $category = $this->categoryRepository->findByUid($pid);
                if ($category != null) {
                    $category->addParent($newCategory);
                    $this->categoryRepository->update($category);
                    $ischild = true;
                }
            }
        }
        if (!$ischild) {
            $this->categoryRepository->add($newCategory);
        }
        $this->cleanUpSessionData();
        parent::addInfo('Your new Category was created.');
        $this->redirect('list');
    }

    /**
     * action edit
     * @param Jro\Videoportal\Domain\Model\Category $category
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("category")
     * @return Response
     */
    public function editAction(\Jro\Videoportal\Domain\Model\Category $category) : Response
    {
        $categories = $this->categoryRepository->findAll();
        $categories = $this->removeDuplicatedCats($categories);
        $pids = array();

        //determine parent ids
        $categories_ = $this->categoryRepository->findAll();
        foreach ($categories_ as $c) {
            foreach ($c->getParent() as $c1) {
                if ($category->getUid() == $c1->getUid()) {
                    array_push($pids, $c->getUid());
                }
            }
        }

        if ($this->session->get('pids')) {
            $pids = unserialize($this->session->get('pids'));
        }

        $this->view->assign('category', $category);
        $this->view->assign('categories', $categories);
        $this->view->assign('pids', $pids);
        
        return $this->htmlResponse();
    }

    /**
     * action update
     * @TYPO3\CMS\Extbase\Annotation\Validate(param="pids", validator="Jro\Videoportal\Validation\Validator\ParentCategoryValidator")
     * @param Jro\Videoportal\Domain\Model\Category $category
     * @param array $pids
     * @return void
     */
    public function updateAction(\Jro\Videoportal\Domain\Model\Category $category, array $pids)
    {
        //set parent categories
        $this->cleanParentRelationship($category);
        foreach ($pids as $pid) {
            if ($pid > 0) {
                $parent = $this->categoryRepository->findByUid($pid);
                if ($parent != null) {
                    $parent->addParent($category);
                    $this->categoryRepository->update($parent);
                }
            }
        }
        $this->categoryRepository->update($category);
        $this->cleanUpSessionData();
        parent::addInfo('Your category was updated.');
        $this->redirect('list');
    }


    /**
     * action delete
     *
     * @param Jro\Videoportal\Domain\Model\Category $category
     * @return void
     */
    public function deleteAction(\Jro\Videoportal\Domain\Model\Category $category)
    {
        $childs = $this->getAllChilds($category->getParent(), array($category));

        //delete categories
        foreach ($childs as $cat) {
            $this->categoryRepository->remove($cat);
            print "remove";
        }

        parent::addInfo('Your category was removed.');
        $this->redirect('list');
    }

    /**
     * action
     *
     * @return void
     */
    public function Action()
    {
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
     * @return integer
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

    /**
     * remove all parents from $cat
     *
     * @return void
     */
    private function cleanParentRelationship($cat)
    {
        $cats = $this->categoryRepository->findAll();
        foreach ($cats as $c) {
            foreach ($c->getParent() as $p) {
                if ($cat->getUid() == $p->getUid()) {
                    $c->removeParent($cat);
                    $this->categoryRepository->update($c);
                }
            }
        }
    }

    /**
     * Determine all childs from $cats recursivly and returns it
     *
     * @return array
     */
    private function getAllChilds($cats, $childs)
    {
        foreach ($cats as $c) {
            array_push($childs, $c);
            if ($c->getParent()->count() > 0) {
                $childs = $this->getAllChilds($c->getParent(), $childs);
            }
        }
        return $childs;
    }

    /**
     * Removes all session variables related to this controller
     *
     * @return void
     */
    protected function cleanUpSessionData()
    {
        $this->session->delete('pids');
    }
}
