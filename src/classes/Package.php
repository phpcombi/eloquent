<?php

namespace Combi\Eloquent;

use Combi\Facades\Runtime as rt;
use Combi\Facades\Tris as tris;
use Combi\Facades\Helper as helper;
use Combi\Core\Abort as abort;
use Combi\Package as core;
use Combi\Eloquent\Package as inner;

class Package extends \Combi\Facades\Package
{
    protected static $pid = 'eloquent';
}
