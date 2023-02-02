<?php
use Jro\Videoportal\Controller\CategoryController;
use Jro\Videoportal\Controller\CommentController;
$_EXTKEY = "videoportal";
/**
 * Definitions for modules
 */
return [
    'videoportalbackendmodul' => [
        'parent' => 'web',
        'position' => ['top'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/web/'.$_EXTKEY,
        'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_videoportalbackendmodul.xlf',
        'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Extension.svg',
        'extensionName' => 'Videoportal',
        'controllerActions' => [
            CategoryController::class => [
                'list', 'show', 'new', 'edit', 'delete', 'create', 'update', 'newStep2'
            ],
            CommentController::class => [
                'list', 'show', 'new', 'edit', 'delete', 'create', 'update', 'newStep2', 'listByVideo', 'setCommentAsWatchedAjax'
            ]
        ],


    ],
];