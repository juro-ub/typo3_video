<?php
return [
    'comment_controller_set_watched' => [
        'path' => '/comment_controller/comment_controller_set_watched',
        'target' => \Jro\Videoportal\Controller\CommentController::class . '::setCommentAsWatchedAjaxAction',
    ]
];
?>