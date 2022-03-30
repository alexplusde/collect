<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
rex_yform_manager_dataset::setModelClass(
    'rex_collect_rss',
    collect_rss::class
);
}
if (rex_addon::get('cronjob')->isAvailable()) {
    rex_cronjob_manager::registerType(rex_cronjob_collect_rss::class);
}
