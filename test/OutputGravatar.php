<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Elijahcruz\Avatar\Avatar;

$avatar = new Avatar('myemailaddress@example.com' , $type = 'gravatar', ['default' => 'mp', 'force_default' => false, 'rating' => 'pg', 'extension' => '.jpg']);

// Change default last second
echo $avatar->option('default', 'identicon')->getUrl();