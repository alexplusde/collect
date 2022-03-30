<?php

class rex_cronjob_collect_rss extends rex_cronjob
{
    public function execute()
    {
       $result = collect_places::fetchByCronjob($this->getParams());
        $this->setMessage(sprintf(
            '%d errors%s, %d items added, %d items updated, %d items not updated because changed by user',
            count($result['errors']),
            $result['errors'] ? ' ('.implode(', ', $result['errors']).')' : '',
            $result['added'],
            $result['updated'],
            $result['untouched']
        ));
        return empty($result['errors']);
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
