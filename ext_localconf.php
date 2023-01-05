<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}
call_user_func(static function () {
    $_EXTKEY = "videoportal";
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:videoportal/Configuration/TypoScript/setup.typoscript">');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptConstants('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:videoportal/Configuration/TypoScript/constants.typoscript">');

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $_EXTKEY,
        'Video',
        array(
            \Jro\Videoportal\Controller\FrontendVideoController::class => 'list,show,notAllowed,switchWatchedStatus, search, showByUid',
            \Jro\Videoportal\Controller\FrontendCommentController::class => 'new,create,list, delete, edit, update, switchObserveStatus, listMyComments, listObservedComments,notAllowed,newMyComment,createMyComment,listMyComments,switchObserveStatusMyComments'

        ),
        // non-cacheable actions
        array(
            \Jro\Videoportal\Controller\FrontendVideoController::class => 'list,show,notAllowed,switchWatchedStatus, search, showByUid',
            \Jro\Videoportal\Controller\FrontendCommentController::class => 'new,create,list, delete, edit, update, switchObserveStatus, listMyComments, listObservedComments,notAllowed,newMyComment,createMyComment,listMyComments,switchObserveStatusMyComments'
        )
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $_EXTKEY,
        'ListCats',
        array(
            \Jro\Videoportal\Controller\FrontendCategoryController::class => 'list',
            \Jro\Videoportal\Controller\FrontendCommentController::class => 'new'

        ),
        // non-cacheable actions
        array(
            \Jro\Videoportal\Controller\FrontendCategoryController::class => 'list',
            \Jro\Videoportal\Controller\FrontendCommentController::class => 'new'
        )
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    video {
                        iconIdentifier = videoportal-plugin-video
                        title = LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video
                        description = LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_video
                        tt_content_defValues {
                            CType = list
                            list_type = videoportal_video
                        }
                    },
                    listcats {
                        iconIdentifier = videoportal-plugin-cats
                        title = LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_category
                        description = LLL:EXT:videoportal/Resources/Private/Language/locallang_db.xlf:tx_videoportal_domain_model_category
                        tt_content_defValues {
                            CType = list
                            list_type = videoportal_listcats
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'videoportal-plugin-video',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:videoportal/Resources/Public/Icons/Extension.svg']
    );
    $iconRegistry->registerIcon(
        'videoportal-plugin-cats',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:videoportal/Resources/Public/Icons/Extension.svg']
    );
});
?>