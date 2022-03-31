<?php

use PicoFeed\Reader\Reader;
use PicoFeed\Processor;

class rex_cronjob_collect_rss extends rex_cronjob
{
    public function execute()
    {

        $errors = [];
        $added = 0;
        $updated = 0;
        $untouched = 0;

        $reader = new Reader();
        $resource = $reader->download($this->getParam('url'), $this->lastModified, $this->etag);
        if (!$resource->isModified()) {
            return;
        }
        $parser = $reader->getParser(
            $resource->getUrl(),
            $resource->getContent(),
            $resource->getEncoding()
        );
        $feed = $parser->execute();

        /** @var Item $rssItem */
        foreach ($feed->getItems() as $rssItem) {

            $item = collect_rss::query()->Where('uuid', rex_yform_value_uuid::guidv4($rssItem->getId()))->findOne();

            if (!$item) {
                $added++;
                $item = collect_rss::create();
                $item->setValue('uuid', rex_yform_value_uuid::guidv4($rssItem->getId()));
                $item->setValue('status', $this->getParam('status'));
            } else {
                $updated++;
            }
            $item->setValue('title', $rssItem->getTitle());

            $item->setValue('raw', json_encode($rssItem));
            $item->setValue('content', $rssItem->getContent());
            $item->setValue('url', $rssItem->getUrl());

            $item->setValue('publishdate', $rssItem->getDate());
            $item->setValue('author', $rssItem->getAuthor());
            $item->setValue('lang', ($rssItem->getLanguage());
            if ($rssItem->getEnclosureUrl()) {
                $item->setValue('media', $rssItem->getEnclosureUrl());
            } elseif ($rssItem->getTag('media:content', 'url')) {
                $item->setValue('media', $rssItem->getTag('media:content', 'url')[0]);
            }
            $item->save();
        }

        $this->setMessage(sprintf(
            '%d errors%s, %d items added, %d items updated, %d items not updated because changed by user',
            count($errors),
            $errors ? ' ('.implode(', ', $errors).')' : '',
            $added,
            $updated,
            $untouched
        ));

        return empty($errors);
    }
    public function getTypeName()
    {
        return rex_addon::get('collect')->i18n('collect_rss');
    }
    public function getParamFields()
    {
        $fields[] = [
            'label' => rex_i18n::msg('collect_rss_url'),
            'name' => 'url',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_rss_url_notice'),
        ];

        return $fields;
    }
}
