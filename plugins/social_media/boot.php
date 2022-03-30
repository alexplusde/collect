<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_collect_social_media',
        collect_social_media::class
    );
}

if (rex_addon::get('cronjob')->isAvailable()) {
    rex_cronjob_manager::registerType(rex_cronjob_collect_social_media_twitter::class);
//    rex_cronjob_manager::registerType(rex_cronjob_collect_social_media_facebook::class);
//    rex_cronjob_manager::registerType(rex_cronjob_collect_social_media_instagram::class);
}
