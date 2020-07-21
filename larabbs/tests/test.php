<?php
require '../vendor/autoload.php';
use \App\Handlers\SlugTranslateHandler;

$o = new SlugTranslateHandler();
$res = $o->translate('sadadad');
echo $res;
