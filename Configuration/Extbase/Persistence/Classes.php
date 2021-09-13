<?php
declare(strict_types=1);

return [
    \Jro\Videoportal\Domain\Model\BeUser::class => [
        'tableName' => 'be_users'
    ],
    \Jro\Videoportal\Domain\Model\User::class => [
        'tableName' => 'fe_users'
    ],
    \Jro\Videoportal\Domain\Model\Group::class => [
        'tableName' => 'fe_groups'
    ],
];