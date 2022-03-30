<?php

# in der uninstall.php sollten Befehle ausgeführt werden, die alle Änderungen, die mit der Installation kamen, entfernen.

# Konfiguration entfernen
# rex_config::removeNamespace("collect");

# YForm-Tabellen löschen (die YForm-Tabellendefinition wird gelöscht, nicht die Datenbank-Tabellen)
# rex_yform_manager_table_api::removeTable('rex_collect');

# Passende Cronjobs deaktivieren oder löschen
# ...
