<?php

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
rex_yform_manager_dataset::setModelClass(
    'rex_collect_social_media',
    collect_social_media::class
);
