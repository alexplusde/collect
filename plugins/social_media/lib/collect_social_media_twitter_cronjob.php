<?php

class rex_cronjob_collect_social_media_twitter extends rex_cronjob
{
    public function execute()
    {

        $errors = [];
        $added = 0;
        $updated = 0;
        $untouched = 0;

        try {
            $socket = rex_socket::factory("api.twitter.com", 443, true);
            $socket->setPath("/2/users/".$this->getParam('user_id')."/tweets?expansions=author_id&user.fields=name,username,protected,verified,withheld,location,url,description&max_results=10");
            $socket->addHeader('Authorization', 'Bearer '.$this->getParam('api_bearer_token'));
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

                $item->setValue('name', $author->name);
                $item->setValue('raw', $response->getBody());
                $item->setValue('content', strip_tags($data->text));
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
        $fields[] =[
            'label' => rex_i18n::msg('collect_social_media_twitter_api_secret'),
            'name' => 'api_secret',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_twitter_api_secret_notice'),
        ];
        $fields[] =[
            'label' => rex_i18n::msg('collect_social_media_twitter_api_bearer_token'),
            'name' => 'api_bearer_token',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_twitter_api_bearer_token_notice'),
        ];
        $fields[] =[
            'label' => rex_i18n::msg('collect_social_media_twitter_user_id'),
            'name' => 'user_id',
            'type' => 'text',
            'notice' => rex_i18n::msg('collect_social_media_twitter_user_id_notice'),
        ];

        return $fields;
    }
}
