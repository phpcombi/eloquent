<?php
namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
};

use Combi\Eloquent as inner;

core::hook()->attach(\Combi\HOOK_ACTION_END, function() {
    $cabins = inner::config('settings')->cabin['auto_release'] ?? [];
    foreach ($cabins as $id) {
        foreach (inner::cabin($id) as $entry) {
            $entry->save();
        }
    }

    // clear all cabin when action done.
    foreach (Cabin::instances() as $cabin) {
        $cabin->clear();
    }
});
