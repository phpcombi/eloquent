<?php

use Combi\Facades\Runtime as rt;
use Combi\Facades\Tris as tris;
use Combi\Facades\Helper as helper;
use Combi\Core\Abort as abort;
use Combi\Package as core;
use Combi\Eloquent\Package as inner;

// set temp dir & init nette tester
define('TEMP_DIR', __DIR__ . '/tmp/' . getmypid());
require __DIR__ . '/init_tester.php';

$loader = include __DIR__.'/../vendor/autoload.php';

// init combi
const TESTING = true;

rt::ready();