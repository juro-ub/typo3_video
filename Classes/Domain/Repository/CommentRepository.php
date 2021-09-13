<?php

namespace Jro\Videoportal\Domain\Repository;

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
class CommentRepository extends \Jro\Videoportal\Domain\Repository\AbstractRepository
{
    /**
     * Create a file reference for a comment
     *
     * @return void
     */
    public function myFileOperationsFal($filename, $filetype, $filesize, $uidNew, $fieldname)
    {
        $contentElement = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord(
            'tx_videoportal_domain_model_comment',
            (int)$uidNew
        );
        $newSysFields = array(
            'pid' => 0,
            'identifier' => '/user_upload/' . $filename,
            'mime_type' => $filetype,
            'name' => $filename,
            'size' => $filesize,
            'storage' => 1,
            'tstamp' => time()
        );
        $affectedRows = $this->getQueryBuilder("sys_file")
            ->insert('sys_file')
            ->values($newSysFields)
            ->execute();
        $uid_local = $this->getQueryBuilder("sys_file")->getConnection()->lastInsertId();
        $this->fileReferenceCreate($uid_local, $uidNew, $contentElement['pid'], $fieldname, "tx_videoportal_domain_model_comment");
    }

    /**
     * find the owner for a comment
     *
     * @return $user
     */
    public function getOwnerByCommentId($uid)
    {
        if ($uid != null && is_numeric($uid)) {
            $userUid = -1;
            $backendUser = false;
            $builder = $this->getQueryBuilder('tx_videoportal_video_my_comment_mm');
            $query = $builder->select('uid_local')->from('tx_videoportal_video_my_comment_mm')->where($builder->expr()->eq('uid_foreign', $builder->createNamedParameter($uid)));
            $row = $query->execute()->fetch(0);
            if($row != null && $row['uid_local'] != null)
                $userUid = $row['uid_local'];
            if ($userUid == -1) {
                $builder = $this->getQueryBuilder('tx_videoportal_video_beuser_my_comment_mm');
                $query = $builder->select('uid_local')->from('tx_videoportal_video_beuser_my_comment_mm')->where($builder->expr()->eq('uid_foreign', $builder->createNamedParameter($uid)));
                $row = $query->execute()->fetch(0);
                if (isset($row['uid_local'])) {
                    $userUid = $row['uid_local'];
                    $backendUser = true;
                }
            }

            if ($backendUser) {
                $table = "be_users";
            } else {
                $table = "fe_users";
            }
            if ($userUid != -1) {
                $builder = $this->getQueryBuilder($table);
                $query = $builder->select('username')->from($table)->where($builder->expr()->eq('uid', $builder->createNamedParameter($userUid)));
                $row = $query->execute()->fetch(0);
                if (isset($row['username'])) {
                    return $row['username'];
                }
            }
        }
        return "";
    }

    /**
     * find all comments
     * @param string $sortingField
     * @param string $sortingType
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findAll($sortingField = 'uid', $sortingType = 'DESCENDING')
    {
        $query = $this->createQuery();
        if (isset($sortingField, $sortingType)) {
            if ($sortingType == "DESCENDING")
                return $query->setOrderings(array($sortingField => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
            else
                return $query->setOrderings(array($sortingField => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
        } else {
            return $query->setOrderings(array('uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
        }
    }

    /**
     * find comments by uid's
     * @param array $uids
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findByUids($uids)
    {
        if (is_array($uids) && count($uids) > 0) {
            $query = $this->createQuery();
            $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
            $query->matching(
                $query->in('uid', $uids)
            );
            return $query->execute();
        }
        return array();
    }

    /**
     * find recursive all child uids
     * @param array $uids
     * @param array $comments
     * @return array $uids
     */
    private function getAllCommentUids($comments, $uids)
    {
        foreach ($comments as $c) {
            array_push($uids, $c->getUid());
            if ($c->getChilds()->count() > 0) {
                $uids = $this->getAllCommentUids($c->getChilds(), $uids);
            }
        }
        return $uids;
    }

    /**
     * find by $string and $video
     * @param string $string
     * @param \Jro\Videoportal\Domain\Model\Video $video
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findByStr($string, $video)
    {
        $validCommentUids = array();
        if ($video != null) {
            foreach ($video->getComments() as $c) {
                array_push($validCommentUids, $c->getUid());
            }
            //$validCommentUids = $this->getAllCommentUids($video->getComments(),array());
        }
        $feUsersUids = array();
        $beUsersUids = array();
        if(!empty($string)){

            $builder = $this->getQueryBuilder('fe_users');
            $stringPdo = $builder->createNamedParameter('%' . $builder->escapeLikeWildcards($string) . '%');
            $query = $builder->select('uid')->from('fe_users')->where($builder->expr()->like('username', $stringPdo));
            $rows = $query->execute()->fetchAll();
            if (($count = count($rows)) > 0) {
                foreach ($rows as $row) {
                    array_push($feUsersUids,$row['uid']);
                }
            }

            //fetch matching be user ids
            $builder = $this->getQueryBuilder('be_users');
            $stringPdo = $builder->createNamedParameter('%' . $builder->escapeLikeWildcards($string) . '%');
            $query = $builder->select('uid')->from('be_users')->where($builder->expr()->like('username', $stringPdo));
            $rows = $query->execute()->fetchAll();
            if (($count = count($rows)) > 0) {
                $i = 1;
                foreach ($rows as $row) {
                    array_push($beUsersUids,$row['uid']);
                }
            }
        }

        //finally get the maching comment uids
        $uids = array();
        if (isset($whereFeusers) || isset($whereBeusers)) {
            $whereVideos = "uid IN (";
            if (isset($whereFeusers)) {
                $builder = $this->getQueryBuilder('tx_videoportal_video_my_comment_mm');
                $query = $builder->select('uid_local')->from('tx_videoportal_video_my_comment_mm')->where($builder->expr()->in('uid_foreign', $feUsersUids));
                $rows = $query->execute()->fetchAll();

                if (($count = count($rows)) > 0) {
                    foreach ($rows as $row) {
                        array_push($uids, $row['uid_local']);
                    }
                }
            }
            if (isset($whereBeusers)) {
                $builder = $this->getQueryBuilder('tx_videoportal_beusers_comments_mm');
                $query = $builder->select('uid_local')->from('tx_videoportal_beusers_comments_mm')->where($builder->expr()->in('uid_foreign', $beUsersUids));
                $rows = $query->execute()->fetchAll();
                if (($count = count($rows)) > 0) {
                    foreach ($rows as $row) {
                        array_push($uids, $row['uid_local']);
                    }
                }
            }
        }

        $query = $this->createQuery();
        $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING));
        $uidsNew = array();
        if ($video != null) {
            if (count($uids) > 0 && strlen($string) > 0) {
                foreach ($uids as $u) {
                    if (in_array($u, $validCommentUids)) {
                        array_push($uidsNew, $u);
                    }
                }
                $uids = $uidsNew;
                $query->matching(
                    $query->logicalAnd(
                        $query->like('text', '%'.$string.'%'),
                        $query->in('uid', $uids)
                    )
                );
            } else {
                $uids = $validCommentUids;
                $query->matching(
                    count($uids) > 0 ? $query->in('uid', $uids) : $query->in('uid', array(0))
                );
            }

        } else {
            $query->matching(
                $query->logicalOr(
                    $query->like('text', '%'.$string.'%'),
                    count($uids) > 0 ? $query->in('uid', $uids) : $query->in('uid', array(0))
                )
            );
        }

        return $query->execute();
    }

    /**
     * find comments by video $uid
     * @param string $uid
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Query
     */
    public function findByVideoId($uid)
    {
        $uids = array();
        $builder = $this->getQueryBuilder('tx_videoportal_video_comment_mm');
        $query = $builder->select('uid_foreign')->from('tx_videoportal_video_comment_mm')->where($builder->expr()->eq('uid_local', $uid));
        $rows = $query->execute()->fetchAll();

        if (($count = count($rows)) > 0) {
            foreach ($rows as $row) {
                array_push($uids, $row['uid_foreign']);
            }
        }

        $query = $this->createQuery();
        $query->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        $query->matching(
            count($uids) > 0 ? $query->in('uid', $uids) : $query->in('uid', array(0))
        );
        return $query->execute();
    }
}

?>
