# Collect - REDAXO-Addon für APIs und Feeds auf Basis von YForm

Collect sammelt anhand unterschiedlicher APIs und Schnittstellen in regelmäßigen Abständen Social Media Posts, RSS-Einträge, Videos und Playlists und andere Inhalte.

## Features

Vorteile gegenüber Feeds für REDAXO

* Basiert auf YForm - alle Vorteile von YOrm und Datasets inkl. eigener Methoden
* Verwaltung über Cronjobs und Table Manager - flexible Verwaltung mit unterschiedlichen Credentials je Quelle / Einsatzzweck
* Eigene Tabellen pro Inhalts-Typ - unterschiedliche Tabellen für Google Places, Videos, Social Meida Posts oder RSS-Einträge mit optimaler Datenbank-Struktur
* Weniger Code, weniger Wartungsaufwand

## Plugins

### RSS Plugin

Nutze den Cronjob für RSS, um Einträge eines RSS-Feeds abzurufen.

#### Verwendung
```php
$items = collect_rss::query()->setWhere('status', 1)->findAll();
foreach($items as $item) {
  echo $item->getTitle();
}
```

### Video Plugin

Rufe Informationen zu Videos anhand Playlists bei Vimeo und YouTube ab.

### Social Media Plugin

Rufe Beiträge von Social-Media-Plattformen anhand von Kanälen und Hashtags ab.

> **Hinweis:** Unterstütze die Entwicklung dieses Addons mit weiteren Feed-Quellen.

### Google Places Plugin

Nutze den Cronjob für Google Places, um einen My Business-Standort inkl Fotos und Rezensionen abzurufen.

Voraussetzungen: Ein gültiger API-Key und die gewünschte Place ID https://developers.google.com/maps/documentation/places/web-service/place-id

#### Verwendung
```php
$place = collect_places::get(1);
echo $place->getName();
```

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/collect/blob/master/LICENSE.md)  

## Autoren

**Alexander Walther**  
http://www.alexplus.de  
https://github.com/alexplusde  

**Projekt-Lead**  
[Alexander Walther](https://github.com/alexplusde)

## Credits
