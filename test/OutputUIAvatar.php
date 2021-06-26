<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Elijahcruz\Avatar\Avatar;

$avatar = new Avatar('Elijah Cruz');

$avatar->uiavatars();

echo $avatar->option('size', 100)->option('background', 'a0a0a0')->options(['color' => 'ff0000', 'uppercase' => true])->option('format', 'svg')->getUrl() . PHP_EOL;

echo $avatar->option('size', 150)->option('rounded', true)->getUrl() . PHP_EOL;
