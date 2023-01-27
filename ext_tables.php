<?php
defined('TYPO3') || die();

call_user_func(static function () {
    $_EXTKEY = "videoportal";

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $_EXTKEY,
        'web',     // Make module a submodule of 'web'
        'videoportalbackendmodul',    // Submodule key
        'top',                        // Position
        array(
             \Jro\Videoportal\Controller\CategoryController::class => 'list, show, new, edit, delete, create, update, newStep2',
            \Jro\Videoportal\Controller\VideoController::class => 'list, show, new, edit, delete, create, update, step1, editStep1, editStep2, editStep3, editStep4, editStep1Redirect, editStep2Redirect, editStep3Redirect, step2, step1Redirect, step2Redirect,step3,step3Redirect, step4, stepSave, ajaxSaveRelVideo,ajaxRemoveFileRef',
            \Jro\Videoportal\Controller\CommentController::class => 'list, show, new, edit, delete, create, update, newStep2, listByVideo, setCommentAsWatchedAjax',
            \Jro\Videoportal\Controller\LevelController::class => 'list, show, new, edit, delete, create, update',
        ),
        array(
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Extension.svg',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_videoportalbackendmodul.xlf',
        )
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Videoportal');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_category', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_category.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_category');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_video', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_video.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_video');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_link', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_link.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_link');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_watchcount');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_level', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_level.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_level');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_targetgroup', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_targetgroup.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_targetgroup');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_author', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_author.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_author');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_videoportal_domain_model_comment', 'EXT:videoportal/Resources/Private/Language/locallang_csh_tx_videoportal_domain_model_comment.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_videoportal_domain_model_comment');


    /*
     * Extend the fe_user and be_user tables
    *
    * */
    //define types when create a new user
    $GLOBALS['TCA']['fe_groups']['columns']['tx_extbase_type']['config']['items'] = "tx_videoportal_domain_model_group";
    $GLOBALS['TCA']['fe_users']['columns']['tx_extbase_type']['config']['items'] = "tx_videoportal_domain_model_user";
    $GLOBALS['TCA']['be_users']['columns']['tx_extbase_type']['config']['items'] = "tx_videoportal_domain_model_beuser";
    //Not needed since TYPO3 v7
    //\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('fe_users');

    $tempColumns = array(
        'watched_videos' => array(
            'exclude' => 1,
            'label' => 'watched videos',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_video',
                'MM' => 'tx_videoportal_video_watched_video_mm',
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'my_comments' => array(
            'exclude' => 1,
            'label' => 'my comments',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_comment',
                'MM' => 'tx_videoportal_video_my_comment_mm',
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'observed_comments' => array(
            'exclude' => 1,
            'label' => 'obeserved comments',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_comment',
                'MM' => 'tx_videoportal_video_observed_comment_mm',
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'watchcount' => array(
            'exclude' => 1,
            'label' => 'watch count',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_watchcount',
                'MM' => 'tx_videoportal_feusers_watchcount_mm',
                'multiple' => 1,
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        )
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumns, 1);

    //Not needed since TYPO3 v 7
    //\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('be_users');

    $tempColumns = array(
        'watched_comments' => array(
            'exclude' => 1,
            'label' => 'watched comments',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_comment',
                'MM' => 'tx_videoportal_beusers_comments_mm',
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'observed_comments' => array(
            'exclude' => 1,
            'label' => 'obeserved comments',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_comment',
                'MM' => 'tx_videoportal_video_beuser_observed_comment_mm',
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'my_comments' => array(
            'exclude' => 1,
            'label' => 'my comments',
            'config' => array(
                'foreign_table' => 'tx_videoportal_domain_model_comment',
                'MM' => 'tx_videoportal_video_beuser_my_comment_mm',
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        )

    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('be_users', $tempColumns, 1);

});
