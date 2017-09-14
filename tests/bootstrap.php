<?php

use Combi\{
    Helper as helper,
    Abort as abort,
    Runtime as rt
};

// set temp dir & init nette tester
require __DIR__.'/init_tester.php';

// init combi
const TESTING = true;

rt::up('eloquent', require __DIR__.'/env.php');
