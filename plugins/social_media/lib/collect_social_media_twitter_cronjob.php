<?php

class rex_cronjob_collect_social_media_twitter extends rex_cronjob
{
    public function execute()
    {

        $errors = [];
        $added = 0;
        $updated = 0;
        $untouched = 0;

        $credentials = [
            'api_key' => $this->getParam('api_key'),
            'places_id' => $this->getParam('place_id')
        ];

        try {
            $socket = rex_socket::factory("maps.googleapis.com", 443, true);
            $socket->setPath("/maps/api/place/details/json?language=de&place_id=".$credentials['places_id']."&key=".$credentials['api_key']);
            $response = $socket->doGet();
            if ($response->isOk()) {
                $result = json_decode($response->getBody());
                if ($result->status != "OK") {
                    $errors[] = $result->error_message;
                } else {
                    $place_details = $result->result;

                    $item = collect_places::query()->Where('uuid', rex_yform_value_uuid::guidv4($this->getParam('place_id')))->findOne();

                    if (!$item) {
                        $added++;
                        $item = collect_places::create();
                    } else {
                        $updated++;
                    }

                    $item->setValue('name', $place_details->name);

                    $item->setValue('raw', json_encode($place_details));
                    $item->setValue('content', strip_tags($place_details->adr_address));
                    $item->setValue('url', $place_details->url);
                    $item->setValue('uuid', rex_yform_value_uuid::guidv4($this->getParam('place_id')));
                    $item->setValue('status', $this->getParam('status'));

                    $item->save();
                }
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

        return $fields;
    }
}
