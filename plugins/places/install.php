<?php

rex_yform_manager_table_api::importTablesets(rex_file::get(rex_path::plugin("collect", "places", 'install/rex_collect_places.tableset.json')));
rex_yform_manager_table_api::importTablesets(rex_file::get(rex_path::plugin("collect", "places", 'install/rex_collect_places_reviews.tableset.json')));
rex_yform_manager_table::deleteCache();
