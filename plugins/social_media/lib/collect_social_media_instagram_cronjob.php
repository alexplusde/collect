<?php

class rex_cronjob_collect_social_media_instagram extends rex_cronjob
{
    public function execute()
    {

        // https://developers.facebook.com/docs/instagram-basic-display-api/getting-started
        // https://developers.facebook.com/async/registration/
        // https://developers.facebook.com/apps/create/

        $errors = [];
        $added = 0;
        $updated = 0;
        $untouched = 0;

        try {
            $socket = rex_socket::factory("graph.instagram.com", 443, true);
            $socket->setPath("/".$this->getParam('user_id')."/?fields=id,username,permalink&access_token=".$this->getParam('access_token')."");
            $response = $socket->doGet();
            if ($response->isOk()) {

                $result = json_decode($response->getBody());

                $author = [];

                foreach($result->data as $data) {
                $item = collect_social_media::query()->Where('uuid', rex_yform_value_uuid::guidv4($data->id))->findOne();

                if (!$item) {
                    $added++;
                    $item = collect_social_media::create();
                } else {
                    $updated++;
                }

                // Felder: https://developers.facebook.com/docs/instagram-basic-display-api/reference/media#fields username, timestam

                $item->setValue('name', $author->name);
                $item->setValue('raw', $response->getBody());
                $item->setValue('content', strip_tags($data->caption));
                $item->setValue('media', strip_tags($data->media_url));
                $item->setValue('permalink', strip_tags($data->permalink));
                $item->setValue('uuid', rex_yform_value_uuid::guidv4($data->id));
                $item->setValue('status', $this->getParam('status'));

                }
                    // $item->save();
            } else {
                $errors[] = "Fehler beim Abruf. Stimmen die Zugangsdaten und Token?";

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
        return rex_addon::get('collect')->i18n('collect_social_media_instagram');
    }
    public function getParamFields()
    {
        $fields[] = [
            'label' => rex_i18n::msg('collect_social_media_instagram_api_key'),
            'name' => 'api_key',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_instagram_api_key_notice'),
        ];
        $fields[] =[
            'label' => rex_i18n::msg('collect_social_media_instagram_api_secret'),
            'name' => 'api_secret',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_instagram_api_secret_notice'),
        ];
        $fields[] =[
            'label' => rex_i18n::msg('collect_social_media_instagram_user_id'),
            'name' => 'user_id',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_instagram_user_id_notice'),
        ];

        return $fields;
    }
}
