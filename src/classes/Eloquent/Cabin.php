<?php

namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
};

class Cabin implements \IteratorAggregate
{
    use core\Traits\Instancable;

    protected $cache_limit      = 10000;

    protected $data     = [];
    protected $cursor   = 0;
    protected $index    = [];

    public function put(Entity $entry, bool $force = false): Entity {
        $index_name = $this->makeIndexName($entry);
        if ($this->has($index_name)) {
            if ($force) {
                unset($this->data[$this->index[$index_name]]);
            } else {
                return $this->data[$this->index[$index_name]];
            }
        }

        $this->data[$this->cursor] = $entry;
        $this->index[$index_name]  = $this->cursor;
        $this->cursor++;
        $this->cursor >= $this->cache_limit && $this->cursor = 0;
        return $this->data[$this->index[$index_name]];
    }

    public function remove(Entity $entry) {
        $index_name = $this->makeIndexName($entry);
        if ($this->has($index_name)) {
            unset($this->data[$this->index[$index_name]]);
            unset($this->index[$index_name]);
        }
    }

    public function clear() {
        $this->data = $this->index = [];
        $this->cursor = 0;
    }

    public function setLimit(int $limit): self {
        $this->_cache_limit = $limit;
        return $this;
    }

    public function getIterator(): iterable {
        foreach ($this->data as $entry) {
            yield $entry;
        }
    }

    private function has(string $index_name): bool {
        return isset($this->index[$index_name]);
    }

    private function makeIndexName(Entity $entry): string {
        return $entry->getConnectionName().'-'.$entry->getTable().'-'.$entry->getId();
    }
}
