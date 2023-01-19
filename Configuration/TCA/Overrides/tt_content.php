<?php
defined('TYPO3') || die();
$_EXTKEY = "videoportal";
/**
 * Register Plugin
 */
$pluginSignatureListCats = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'ListCats',
    'The Category Menubar',
    'EXT:videoportal/Resources/Public/Icons/Extension.svg'

);

/**
 * Register Plugin
 */
$pluginSignatureVideo = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Video',
    'Video content',
    'EXT:videoportal/Resources/Public/Icons/Extension.svg'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignatureListCats]
    = 'pi_flexform';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignatureVideo]
    = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignatureListCats,
    'FILE:EXT:videoportal/Configuration/Flexforms/PluginListCatsSettings.xml'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignatureVideo,
    'FILE:EXT:videoportal/Configuration/Flexforms/PluginVideoSettings.xml'
);