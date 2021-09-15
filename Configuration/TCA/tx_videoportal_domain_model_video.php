<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'hideTable' => false,
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'path_mp4,path_webm,path_ogg,time,title,about,exam_relevant,meta_keywords,meta_description,meta_title,learning_objectives,thumbnail,targetgroups,levels,accessibilities,tags,links,categories,files,transcripts,chapters,authors,comments,',
        'iconfile' => 'EXT:videoportal/Resources/Public/Icons/tx_videoportal_domain_model_video.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, path_mp4, path_webm, path_ogg, time, about, exam_relevant, meta_keywords, meta_description, meta_title, learning_objectives, thumbnail, targetgroups, levels, accessibilities, tags, links, categories, files, transcripts, chapters, authors, comments',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title,path_mp4, path_webm, path_ogg, about, exam_relevant, meta_keywords, meta_description, meta_title, learning_objectives, thumbnail, targetgroups, levels, accessibilities, tags, links, categories, files, transcripts, chapters, authors, next_videos,requirement_videos,extension_videos,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_videoportal_domain_model_video',
                'foreign_table_where' => 'AND {#tx_videoportal_domain_model_video}.{#pid}=###CURRENT_PID### AND {#tx_videoportal_domain_model_video}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'path_mp4' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.path_mp4',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('path_mp4', array(
                'size' => 5,
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => 'required',
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']. ',mp4'
            )
        ),
        'path_webm' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.path_webm',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('path_webm', array(
                'size' => 5,
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']. ',webm'
            )
        ),
        'path_ogg' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.path_ogg',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('path_ogg', array(
                'size' => 5,
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']. ',ogg,ogv'
            )
        ),
        'time' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.time',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'datetime,required',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'watch_count' => array(
            'exclude' => 1,
            'label' => 'Watch count',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'default' => 0
            ),
        ),
        'title' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'about' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.about',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim,required'
            ),
        ),
        'exam_relevant' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.exam_relevant',
            'config' => array(
                'type' => 'check',
                'default' => 0
            ),
        ),
        'meta_keywords' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.meta_keywords',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'meta_description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.meta_description',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'meta_title' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.meta_title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'learning_objectives' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.learning_objectives',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ),
        ),
        'thumbnail' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.thumbnail',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('thumbnail', array(
                'size' => 5,
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => 'required',
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
        ),
        'targetgroups' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.target_group',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_targetgroup',
                'MM' => 'tx_videoportal_video_targetgroup_mm',
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'next_videos' => array(
            'exclude' => 1,
            'label' => 'Next Videos',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_video',
                'MM' => 'tx_videoportal_video_next_video_mm',
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
            ),
        ),
        'requirement_videos' => array(
            'exclude' => 1,
            'label' => 'Required Videos',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_video',
                'MM' => 'tx_videoportal_video_next_video_mm',
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
            ),
        ),
        'extension_videos' => array(
            'exclude' => 1,
            'label' => 'Extended Videos',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_video',
                'MM' => 'tx_videoportal_video_next_video_mm',
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
            ),
        ),
        'levels' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.level',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_level',
                'MM' => 'tx_videoportal_video_level_mm',
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'accessibilities' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.accessibility',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'foreign_table' => 'fe_groups',
                'MM' => 'tx_videoportal_video_accessibility_mm',
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'links' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.links',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_videoportal_domain_model_link',
                'foreign_field' => 'video',
                'MM' => 'tx_videoportal_video_link_mm',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),

        'categories' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.categories',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'foreign_table' => 'tx_videoportal_domain_model_category',
                'foreign_field' => 'video',
                'MM' => 'tx_videoportal_video_category_mm',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),

        'files' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.files',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('files', array(
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
            ),
            ),
        ),

        'transcripts' => array(
            'exclude' => 1,
            'label' => 'Transcript Vtt File',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('transcripts', array(
                'size' => 5,
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']. ',vtt'
            )
        ),
        'chapters' => array(
            'exclude' => 1,
            'label' => 'Chapters Vtt File',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('chapters', array(
                'size' => 5,
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                ),
                'minitems' => 0,
                'maxitems' => 1,
            ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']. ',vtt'
            )
        ),
        'authors' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.authors',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_videoportal_domain_model_author',
                'MM' => 'tx_videoportal_video_author_mm',
                'foreign_field' => 'video',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'comments' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video.comments',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_videoportal_domain_model_comment',
                'foreign_field' => 'video',
                'MM' => 'tx_videoportal_video_comment_mm',
                'maxitems' => 9999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'user' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
    ),
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
?>
