<?php
namespace Combi\Eloquent;

use Combi\{
    Helper as helper,
    Abort as abort,
    Runtime as rt
};

rt::core()->hook()->attach(\Combi\HOOK_ACTION_END, function() {
    $cabins = rt::eloquent()->config('settings')->cabin['auto_release'] ?? [];
    foreach ($cabins as $id) {
        foreach (rt::eloquent()->cabin($id) as $entry) {
            $entry->save();
        }
    }

    // clear all cabin when action done.
    foreach (Cabin::instances() as $cabin) {
        $cabin->clear();
    }
});
