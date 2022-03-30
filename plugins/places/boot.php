<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_collect_places',
        collect_places::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_collect_places_review',
        collect_places_review::class
    );
}

if (rex_addon::get('cronjob')->isAvailable()) {
    rex_cronjob_manager::registerType(rex_cronjob_collect_places::class);
    rex_cronjob_manager::registerType(rex_cronjob_collect_places_review::class);
}
