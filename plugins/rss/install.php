<?php

rex_yform_manager_table_api::importTablesets(rex_file::get($this->getPath('install/rex_collect_rss.tableset.json')));
rex_yform_manager_table::deleteCache();
