<?php
/* Tablesets aktualisieren */

rex_yform_manager_table_api::importTablesets(rex_file::get(rex_path::plugin("collect", "video", 'install/rex_collect_video.tableset.json')));
rex_yform_manager_table::deleteCache();
