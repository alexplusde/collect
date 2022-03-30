<?php

rex_yform_manager_table_api::importTablesets(rex_file::get($this->getPath('install/rex_collect_social_media.tableset.json')));
rex_yform_manager_table::deleteCache();
