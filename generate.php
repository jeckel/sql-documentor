<?php
/**
 * Created by PhpStorm.
 * User: jeckel
 * Date: 14/04/18
 * Time: 11:23
 */

include 'vendor/autoload.php';

//(new \SqlDocumentor\Bootstrap(include __DIR__ . '/src/config/config.php'))();
(new \SqlDocumentor\Bootstrap(include __DIR__ . '/config/sql-documentor.config.php'))();
