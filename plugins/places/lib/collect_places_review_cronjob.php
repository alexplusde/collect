<?php

class rex_cronjob_collect_google_places_review extends rex_cronjob
{
    public function execute()
    {
       $result = collect_places_eview::fetchByCronjob($this->getParams());
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
        return rex_addon::get('collect')->i18n('collect_google_places_review');
    }
    public function getParamFields()
    {
        $fields[] = [
            'label' => rex_i18n::msg('collect_google_places_review_place_id'),
            'name' => 'place_id',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_google_places_review_place_id_notice'),
        ];
        $fields[] = [
            'label' => rex_i18n::msg('collect_google_places_review_api_key'),
            'name' => 'api_key',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_google_places_review_api_key_notice'),
        ];

        return $fields;
    }
}
