<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
rex_yform_manager_dataset::setModelClass(
    'rex_collect_places',
    collect_places::class
);
