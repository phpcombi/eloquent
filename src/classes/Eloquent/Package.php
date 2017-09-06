<?php

namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
};

use Illuminate\Database\Capsule\Manager as Capsule;

class Package extends \Combi\Package
{
    protected static $_pid = 'eloquent';

    protected $capsule = null;

    public function initManager(Capsule $capsule = null): void {
        if ($capsule) {
            $this->capsule = $capsule;
        }
        if ($this->capsule) {
            return;
        }

        //创建Eloquent
        $capsule = new Capsule;

        $db_confs = $this->config('databases');
        foreach ($db_confs as $name => $conf) {
            $capsule->addConnection($conf, $name);
        }
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $this->capsule = $capsule;
    }

    public function manager(): Capsule {
        return $this->capsule;
    }

    public function cabin($id = 0): Cabin {
        return Cabin::instance($id);
    }

    public function __call(string $name, array $arguments) {
        return $this->capsule->$name(...$arguments);
    }
}
