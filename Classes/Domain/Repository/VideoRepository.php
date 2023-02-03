<?php

namespace Jro\Videoportal\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

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
class VideoRepository extends \Jro\Videoportal\Domain\Repository\AbstractRepository {

    /**
     * Create a file reference for a video
     *
     * @return int uid of sys_file
     */
    public function myFileOperationsFal($filename, $filetype, $filesize, $uidNew, $fieldname): int {
        $contentElement = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord(
                        'tx_videoportal_domain_model_video',
                        (int) $uidNew
        );
        $newSysFields = array(
            'pid' => $contentElement['pid'],
            'identifier' => '/user_upload/' . $filename,
            'mime_type' => $filetype,
            'name' => $filename,
            'size' => $filesize,
            'storage' => 1
        );
        $affectedRows = $this->getQueryBuilder("sys_file")
                ->insert('sys_file')
                ->values($newSysFields)
                ->execute();
        $uid_local = $this->getQueryBuilder("sys_file")->getConnection()->lastInsertId();
        $this->fileReferenceCreate($uid_local, $uidNew, $contentElement['pid'], $fieldname, 'tx_videoportal_domain_model_video');
        return $uid_local;
    }

    /**
     * find by $string
     * @param string $string
     * @param boolean $hidden
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findByStr($string, $hidden = true) {
        //fetch machting author ids
        $builder = $this->getQueryBuilder('tx_videoportal_domain_model_author', $hidden);
        $stringPdo = $builder->createNamedParameter('%' . $builder->escapeLikeWildcards($string) . '%');
        $query = $builder->select('uid')->from('tx_videoportal_domain_model_author')->where($builder->expr()->like('firstname', $stringPdo))->orWhere($builder->expr()->like('lastname', $stringPdo));
        $rows = $query->execute()->fetchAll();
        $whereAuthors = array();
        if (($count = count($rows)) > 0) {
            foreach ($rows as $row) {
                array_push($whereAuthors, $row['uid']);
            }
        }
        //fetch matching category ids
        $builder = $this->getQueryBuilder('tx_videoportal_domain_model_category', $hidden);
        $stringPdo = $builder->createNamedParameter('%' . $builder->escapeLikeWildcards($string) . '%');
        $query = $builder->select('uid')->from('tx_videoportal_domain_model_category')->where($builder->expr()->like('title', $stringPdo))->orWhere($builder->expr()->like('description', $stringPdo));
        $rows = $query->execute()->fetchAll();
        $whereCats = array();
        if (($count = count($rows)) > 0) {
            foreach ($rows as $row) {
                array_push($whereCats, $row['uid']);
            }
        }

        //finally get the maching video uids
        $uids = array();
        if (count($whereAuthors) > 0 || count($whereCats) > 0) {
            if (count($whereAuthors) > 0) {
                $builder = $this->getQueryBuilder('tx_videoportal_video_author_mm', $hidden);
                $query = $builder->select('uid_local')->from('tx_videoportal_video_author_mm')->where($builder->expr()->in('uid_foreign', $whereAuthors));
                $rows = $query->execute()->fetchAll();

                if (($count = count($rows)) > 0) {
                    foreach ($rows as $row) {
                        array_push($uids, $row['uid_local']);
                    }
                }
            }
            if (count($whereCats) > 0) {
                $builder = $this->getQueryBuilder('tx_videoportal_video_category_mm', $hidden);
                $query = $builder->select('uid_local')->from('tx_videoportal_video_category_mm')->where($builder->expr()->in('uid_foreign', $whereCats));
                $rows = $query->execute()->fetchAll();

                if (($count = count($rows)) > 0) {
                    foreach ($rows as $row) {
                        array_push($uids, $row['uid_local']);
                    }
                }
            }
        }

        //query videos
        $query = $this->createQuery();
        $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        $query->matching(
                $query->logicalOr(
                        $query->logicalOr(
                                $query->logicalOr(
                                        $query->like('title', '%' . $string . '%'),
                                        $query->like('about', '%' . $string . '%')
                                ),
                                $query->logicalOr(
                                        $query->like('meta_description', '%' . $string . '%'),
                                        $query->like('meta_keywords', '%' . $string . '%')
                                )
                        ),
                        count($uids) > 0 ? $query->in('uid', $uids) : $query->in('uid', array(0))
                )
        );
        return $query->execute();
    }

    public function deleteFilesWithNoRefs($file = null) {
        
    }

    /**
     * find by $category uid
     * @param string $uid
     * @param string $userId
     * @param boolean $watched
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findByCatUid($uid, $userId, $watched = false) {
        //get Watched video uids
        $watchedUids = $this->getWachedVideoUidsByUserUid($userId);
        //video uids which are associated with category
        $builder = $this->getQueryBuilder('tx_videoportal_video_category_mm');
        $query = $builder->select('uid_local')->from('tx_videoportal_video_category_mm')->where($builder->expr()->eq('uid_foreign', $uid));
        $rows = $query->execute()->fetchAll();

        $allUids = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                array_push($allUids, $row['uid_local']);
            }
        }
        //dermine watched or unwatched ids
        if ($watched) {
            $unwatchedUids = array_diff($allUids, $watchedUids);
            $uids = array_diff($allUids, $unwatchedUids);
        } else {
            $uids = array_diff($allUids, $watchedUids);
        }
        $videos = null;
        if (count($uids) > 0) {
            $query = $this->createQuery();
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $query->matching($query->in('uid', $uids));
            $videos = $query->execute();
            return $videos;
        }
        return null;
    }

    /**
     * find by $category uid
     * @param string $uid
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findAllByCatUid($uid) {
        $builder = $this->getQueryBuilder('tx_videoportal_video_category_mm');
        $query = $builder->select('uid_local')->from('tx_videoportal_video_category_mm')->where($builder->expr()->eq('uid_foreign', $uid));
        $rows = $query->execute()->fetchAll();

        $allUids = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                array_push($allUids, $row['uid_local']);
            }
        }
        $videos = null;
        if (count($allUids) > 0) {
            $query = $this->createQuery();
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $query->matching($query->in('uid', $allUids));
            $videos = $query->execute();
            return $videos;
        }
        return null;
    }

    /**
     * find by $categories
     * @param array $cats
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findByCats($cats) {
        if (count($cats) == 0)
            return null;
        $catsUid = array();
        foreach ($cats as $c) {
            array_push($catsUid, $c->getUid());
        }
        $builder = $this->getQueryBuilder('tx_videoportal_video_category_mm');
        $query = $builder->select('uid_local')->from('tx_videoportal_video_category_mm')->where($builder->expr()->in('uid_foreign', $catsUid));
        $rows = $query->execute()->fetchAll();

        $whereVideos = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                array_push($whereVideos, $row['uid_local']);
            }
        }
        $videos = null;
        if (strlen($whereVideos) > 0) {
            $query = $this->createQuery();
            $query->matching($query->in('uid', $whereVideos));
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $videos = $query->execute();
            $videos->rewind();
            return $videos;
        }
        return $videos;
    }

    /**
     * find related videos
     * @param \Jro\Videoportal\Domain\Model\Video $video
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findRelatedVideos($video) {
        if ($video->getCategories()->count() == 0)
            return null;
        $cats = $video->getCategories();
        $catsUid = array();
        foreach ($cats as $c) {
            array_push($catsUid, $c->getUid());
        }
        $builder = $this->getQueryBuilder('tx_videoportal_video_category_mm');
        $query = $builder->select('uid_local')->from('tx_videoportal_video_category_mm')->where($builder->expr()->in('uid_foreign', $catsUid));
        $rows = $query->execute()->fetchAll();

        //print_r($rows);
        //  exit;

        $uids = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                if ($row['uid_local'] != $video->getUid())
                    array_push($uids, $row['uid_local']);
            }
        }

        $videos = null;
        if (count($uids) > 0) {
            $query = $this->createQuery();
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $query->matching($query->in('uid', $uids));
            $videos = $query->execute();
            return $videos;
        }
        return $videos;
    }

    /**
     * findAll
     * @param string $sortingField
     * @param string $sortingType
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findAll($sortingField = 'uid', $sortingType = 'DESCENDING') {
        $query = $this->createQuery();
        if ($sortingType == "DESCENDING")
            return $query->setOrderings(array($sortingField => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
        else
            return $query->setOrderings(array($sortingField => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
    }

    /**
     * findAll watched videos
     * @param string $userId
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findAllWatchedVideos($userId) {
        $uids = $this->getWachedVideoUidsByUserUid($userId);
        $videos = null;
        $query = $this->createQuery();
        if (count($uids) > 0) {
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $query->matching($query->in('uid', $uids));
            $videos = $query->execute();
            return $videos;
        }
        return null;
    }

    /**
     * return watched Video uid's
     * @param string $userId
     * @return array
     */
    private function getWachedVideoUidsByUserUid($userId) {
        $builder = $this->getQueryBuilder('tx_videoportal_video_watched_video_mm');
        $query = $builder->select('uid_foreign')->from('tx_videoportal_video_watched_video_mm')->where($builder->expr()->eq('uid_local', $userId));
        $rows = $query->execute()->fetchAll();

        $uids = array();
        foreach ($rows as $row) {
            array_push($uids, $row['uid_foreign']);
        }
        return $uids;
    }

    /**
     * return all Video uid's
     * @param string $userId
     * @return array
     */
    private function getAllVideoUids() {
        $builder = $this->getQueryBuilder('tx_videoportal_domain_model_video');
        $query = $builder->select('uid')->from('tx_videoportal_domain_model_video')->where($builder->expr()->gt('uid', 0));
        $rows = $query->execute()->fetchAll();

        $uids = array();
        foreach ($rows as $row) {
            array_push($uids, $row['uid']);
        }
        return $uids;
    }

    /**
     * findAll unwatched videos
     * @param string $userId
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findAllUnwatchedVideos($userId) {
        $allUids = $this->getAllVideoUids();
        $watchedUids = $this->getWachedVideoUidsByUserUid($userId);
        $uids = array_diff($allUids, $watchedUids);
        $videos = null;
        $query = $this->createQuery();
        if (count($uids) > 0) {
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $query->matching($query->in('uid', $uids));
            $videos = $query->execute();
            return $videos;
        }
        return null;
    }

}

?>
