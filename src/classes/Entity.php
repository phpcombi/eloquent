<?php

namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core,
    Runtime as rt
};

use Illuminate\Database\Eloquent\{
    Collection,
    Model
};

/**
 *
 * @author andares
 */
abstract class Entity extends Model implements Core\Interfaces\Confirmable {
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

    protected $_cabin_id = 0;

    public static function find($id) {
        $entry = static::findAtCabin($id);
        if ($entry) {
            return $entry;
        }

        $entry = (new static)->newQuery()->find($id);
        if ($entry) {
            $entry->at();
        }
        return $entry;
    }

    private static function findAtCabin($id): ?Entity {
        $tmp    = new static();
        $cabin  = $tmp->cabin();
        if ($cabin) {
            $index_name = $cabin->makeIndexName($tmp->getConnectionName(),
                $tmp->getTable(), $id);
            if ($cabin->has($index_name)) {
                return $cabin->get($index_name);
            }
        }
        return null;
    }

    public function findOrFail($id) {
        $entry = static::findAtCabin($id);
        if ($entry) {
            return $entry;
        }

        $entry = (new static)->newQuery()->findOrFail($id);
        if ($entry) {
            $entry->at();
        }
        return $entry;
    }

    public function save(array $options = []) {
        $need_put = !$this->exists && $this->_cabin_id !== null;
        if ($result = parent::save() && $need_put) {
            $this->at($this->_cabin_id);
        }
        return $result;
    }

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
        if (!$this->getId()) {
            return $this;
        }

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
        return $this->_cabin_id === null ? null : rt::eloquent()->cabin($this->_cabin_id);
    }

    public function confirm() {
        $this->_confirm();
        return $this;
    }

    protected function _confirm() {}
}
