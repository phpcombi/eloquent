<?php

namespace Combi\Eloquent;

use Combi\Facades\Runtime as rt;

rt::register(Package::instance(__DIR__),
    /*'dependencies', 'hooks',*/ 'helpers');
