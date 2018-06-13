<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 13/06/18
 * Time: 18:51
 */

return [
    'table' => [
        'engine'  => 'InnoDB',
        'charset' => 'utf8',
        'comment' => 'Cities of the world'
    ],
    'columns' => [
        'id' => [
            'type' => 'int(11)',
            'null' => false,
            'auto-increment' => true
        ],
        'id_user' => [
            'type' => 'int(11)',
            'null' => false,
        ],
        'area_code' => [
            'type' => 'varchar(5)',
            'null' => true,
            'comment' => 'Code of \'Country\' area'
        ],
        'city' => [
            'type' => 'varchar(64)',
            'null' => false
        ]
    ],
    'primary-key' => [
        'id'
    ],
    'keys' => [
        'city_to_user_ibfk_1' => [
            'id_user'
        ]
    ],
    'foreign-keys' => [
        'id_user' => [
            'table' => 'user',
            'field' => 'id'
        ]
    ]
];
