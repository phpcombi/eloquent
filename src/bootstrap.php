<?php

namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Runtime as rt
};

rt::register(Package::instance(__DIR__),
    'dependencies', 'helpers', 'hooks');
