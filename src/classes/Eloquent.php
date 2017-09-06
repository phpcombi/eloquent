<?php

namespace Combi;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
};

class Eloquent
{
    use Core\Traits\StaticAgent;

    public static function instance(): Eloquent\Package {
        return Eloquent\Package::instance();
    }

}
