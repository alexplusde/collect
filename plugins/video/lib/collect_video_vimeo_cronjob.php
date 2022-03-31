<?php

class rex_cronjob_collect_video_vimeo extends rex_cronjob
{
    public function execute()
    {

        $errors = [];
        $added = 0;
        $updated = 0;
        $untouched = 0;

        try {

            $argSeparator = ini_set('arg_separator.output', '&');

            $vimeo = new Vimeo($this->getParam('client_id'), $this->getParam('client_secret'),);
            if (!empty($this->getParam('access_token'))) {
                $vimeo->setToken($this->getParam('access_token'),);
                $videos = $vimeo->request('/me/videos?per_page=100');
                // $videos = $videos['body'];
                $videos_data = $videos['body']['data'];
                while($videos['body']['paging']['next'] != "") {
                    $videos = $vimeo->request($videos['body']['paging']['next']);
                    $videos_data = array_merge($videos_data, $videos['body']['data']);
                    }
                $videos = $videos_data;
                
            }

            ini_set('arg_separator.output', $argSeparator);
    
            foreach ($videos as $video) {

                $uri = $video['uri'];
                $uri = str_replace("/videos/", "", $uri);

                $item = collect_video::query()->Where('uuid', rex_yform_value_uuid::guidv4($uri))->findOne();

                if (!$item) {
                    $added++;
                    $item = collect_social_media::create();
                    $item->setValue('uuid', rex_yform_value_uuid::guidv4($uri));
                    $item->setValue('status', $this->getParam('status'));

                } else {
                    $updated++;
                }

                $item->setValue('title', $video['name']);
                $item->setValue('raw', json_encode($video));
                $item->setValue('content', $video['description']);
                    
                $item->setValue('url', $video['link']);
                    
                $item->setValue('media', $video->snippet->thumbnails->maxres->url);

                $item->setValue('publishdate', new DateTime($video['created_time']));
                    
                $item->setValue('author', $video->snippet->channelTitle);
                $item->save();
            } 

        } catch (rex_socket_exception $e) {
            $errors[] = $e->getMessage();
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
        $fields[] = [
            'label' => rex_i18n::msg('collect_video_vimeo_client_id'),
            'name' => 'client_id',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_video_vimeo_client_id_notice'),
        ];
        $fields[] = [
            'label' => rex_i18n::msg('collect_video_vimeo_client_secret'),
            'name' => 'client_secret',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_video_vimeo_client_secret_notice'),
        ];

        return $fields;
    }
}
