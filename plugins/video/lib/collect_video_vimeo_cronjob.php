<?php

class rex_cronjob_collect_video_vimeo extends rex_cronjob
{
    public function execute()
    {
       $result = collect_places::fetchVimeoByCronjob($this->getParams());
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
        return rex_addon::get('collect')->i18n('collect_video_vimeo');
    }
    public function getParamFields()
    {
        $fields[] = [
            'label' => rex_i18n::msg('collect_video_vimeo_url'),
            'name' => 'url',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_video_vimeo_url_notice'),
        ];

        return $fields;
    }
}
