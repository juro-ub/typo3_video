<?php
declare(strict_types=1);

return [
    \Jro\Videoportal\Domain\Model\BeUser::class => [
        'tableName' => 'be_users',
        'properties' => [
            'userName' => [
                'fieldName' => 'username',
            ],
            'isAdministrator' => [
                'fieldName' => 'admin',
            ],
            'isDisabled' => [
                'fieldName' => 'disable',
            ],
            'realName' => [
                'fieldName' => 'realName',
            ],
            'startDateAndTime' => [
                'fieldName' => 'starttime',
            ],
            'endDateAndTime' => [
                'fieldName' => 'endtime',
            ],
            'lastLoginDateAndTime' => [
                'fieldName' => 'lastlogin',
            ],
        ],
    ],
    \Jro\Videoportal\Domain\Model\User::class => [
        'tableName' => 'fe_users'
    ],
    \Jro\Videoportal\Domain\Model\Group::class => [
        'tableName' => 'fe_groups'
    ],
];