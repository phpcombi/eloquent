<?php

namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
};

use Illuminate\Database\Eloquent\{
    Collection,
    Model
};

use Combi\Eloquent as inner;

/**
 *
 * @author andares
 */
abstract class Entity extends Model implements core\Interfaces\Confirmable {
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $connection = 'default';
    protected $primaryKey = 'id';
    // public $timestamps    = false;
    // public $incrementing  = false;

    protected $fillable = [
    ];
    protected $casts = [
        'id'    => 'integer',
    ];

    protected $_cabin_id = null;

    public function delete() {
        if (parent::delete()) {
            $cabin = $this->cabin();
            $cabin && $cabin->remove($this);
        }
    }

    public function getId() {
        return $this->getKey();
    }

    public function at($cabin_id = 0, bool $force = false): self {
        if ($this->_cabin_id !== null) {
            $this->cabin()->remove($this);
        }

        $this->_cabin_id = $cabin_id;
        if ($this->_cabin_id !== null) {
            return $this->cabin()->put($this, $force);
        }
        return $this;
    }

    public function cabin(): ?Cabin {
        return $this->_cabin_id === null ? null : inner::cabin($this->_cabin_id);
    }

    public function confirm() {
        $this->_confirm();
        return $this;
    }

    protected function _confirm() {}
}
