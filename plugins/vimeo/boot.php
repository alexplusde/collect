<?php
if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_collect_vimeo',
        collect_vimeo::class
    );
}
if (rex_addon::get('cronjob')->isAvailable()) {
    rex_cronjob_manager::registerType(rex_cronjob_collect_video_vimeo::class);
}
// Poster image from vimeo.com
if (rex::isBackend()) {
    if (rex_request('table_name') == 'rex_collect_vimeo' or rex_be_controller::getCurrentPage() == 'collect/vimeo') {
        rex_extension::register('YFORM_DATA_LIST', function ($ep) {
            $list = $ep->getSubject();
            $list->setColumnFormat('preview_image', 'custom', function ($params) {
                return '<img style="width: 150px; height: auto;" src="' . $params['list']->getValue('preview_image') . '">';
            });
        });
    }
}
