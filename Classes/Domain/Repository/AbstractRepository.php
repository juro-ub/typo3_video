<?php

namespace Jro\Videoportal\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

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
class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * dont respect on storage page
     * @param string $tableName
     * @return \TYPO3\CMS\Core\Database\Query\QueryBuilder
     */
    protected function getQueryBuilder($tableName = "tt_content",$hidden = false)
    {
        $querySettings = new \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings();
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($tableName);
        // Remove all default restrictions (delete, hidden, starttime, stoptime), but add DeletedRestriction again
        $queryBuilder->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction::class));
        if($hidden){
            $queryBuilder->getRestrictions()
                ->add(GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction::class));
        }
        return $queryBuilder;
    }

    /**
     * dont respect on storage page
     *
     * @return void
     */
    public function initializeObject()
    {
        $querySettings = new \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings();
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setRespectSysLanguage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Creates a file reference
     *
     * @param int $fileUid Uid of the file
     * @param int $elementUid Uid of the content element
     * @param int $elementPid Pid of the content element
     * @param string $fieldname Fieldname in table tt_content
     * @param string $tablenames Name of the table containing the related record.
     */
    protected function fileReferenceCreate($fileUid, $elementUid, $elementPid, $fieldname, $tablenames = "tt_content"): bool
    {
        // Early return if either item is missing
        if ((int)$fileUid === 0 || (int)$elementUid === 0) {
            return false;
        }
        // Assemble DataHandler data
        $newId = 'NEW1234';
        $data = [];
        $data['sys_file_reference'][$newId] = [
            'table_local' => 'sys_file',
            'uid_local' => $fileUid,
            'tablenames' => $tablenames,
            'uid_foreign' => $elementUid,
            'fieldname' => $fieldname,
            'pid' => $elementPid,
        ];
        $data[$tablenames][$elementUid] = [
            $fieldname => $newId,
            'pid' => $elementPid,
        ];
        // Get an instance of the DataHandler and process the data
        $dataHandler = GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();
        // Error or success
        if (count($dataHandler->errorLog) === 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * remove file reference and file for a comment
     * @return void
     */
    public function removeFile($uid)
    {
        $queryBuilder = $this->getQueryBuilder("sys_file_reference");
        $statement = $queryBuilder
            ->select('uid_local')
            ->from('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter(intval($uid)))
            )
            ->execute();
        $row = $statement->fetch(0);
        if($row['uid_local'] > 0){
            $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);
            $file = $resourceFactory->getFileObject($row['uid_local']);
            $file->getStorage()->deleteFile($file);
        }
    }
}

?>