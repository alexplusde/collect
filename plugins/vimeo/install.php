<?php
/* Tablesets aktualisieren */

rex_yform_manager_table_api::importTablesets(rex_file::get(rex_path::plugin("collect", "vimeo", 'install/rex_collect_vimeo.tableset.json')));
rex_yform_manager_table::deleteCache();
