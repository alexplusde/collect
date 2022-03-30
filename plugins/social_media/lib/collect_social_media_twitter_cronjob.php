<?php

class rex_cronjob_collect_social_media_twitter extends rex_cronjob
{
    public function execute()
    {
       $result = collect_social_media::fetchTwitterByCronjob($this->getParams());
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
        return rex_addon::get('collect')->i18n('collect_social_media_twitter');
    }
    public function getParamFields()
    {
        $fields[] = [
            'label' => rex_i18n::msg('collect_social_media_twitter_api_key'),
            'name' => 'api_key',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_twitter_api_key_notice'),
        ];

        return $fields;
    }
}
