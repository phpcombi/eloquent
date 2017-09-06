<?php

namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
};

core::register(Package::instance(__DIR__),
    'dependencies', 'helpers', 'hooks');
