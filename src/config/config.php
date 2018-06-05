<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 05/06/18
 * Time: 20:31
 */

$dflConfig = [

];

return [
    'config' => [
        array_merge($dflConfig, getenv()),
    ],
    'services' => [
        'sql-parser'      => function() { return new \PHPSQLParser\PHPSQLParser(); },
        'markdown-helper' => function() { return new \SqlDocumentor\Markdown\Markdown(); },
        'yaml-parser'     =>  function($c) {
            return new \SqlDocumentor\Services\YamlParser($c['config']->get('YML_DIRECTORY'));
        },
        'create-table-parser' => function($c) {
            return new \SqlDocumentor\Services\CreateTableParser($c['sql-parser']);
        },
    ]
];
