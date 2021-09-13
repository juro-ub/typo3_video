<?php
defined('TYPO3_MODE') || die();
$_EXTKEY = "videoportal";
/**
 * Register Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'ListCats',
    'The Category Menubar',
    'EXT:videoportal/Resources/Public/Icons/Extension.svg'

);

/**
 * Register Plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Video',
    'Video content',
    'EXT:videoportal/Resources/Public/Icons/Extension.svg'
);