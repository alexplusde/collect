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

            $vimeo = new Vimeo\Vimeo($this->getParam('client_id'), $this->getParam('client_secret'),);
            if (!empty($this->getParam('access_token'))) {
                $vimeo->setToken($this->getParam('access_token'),);
                $videos = $vimeo->request('/me/videos?per_page=100');
                $videos_data = $videos['body']['data'];
                while($videos['body']['paging']['next'] != "") {
                    $videos = $vimeo->request($videos['body']['paging']['next']);
                    $videos_data = array_merge($videos_data, $videos['body']['data']);
                    }
                $videos = $videos_data;
            }
            ini_set('arg_separator.output', $argSeparator);
            foreach ($videos as $video) {
                $uri = $video['link'];
                $item = collect_vimeo::query()->Where('url', $uri)->findOne();
                if($item && $item->url == $uri)
                    {
                    $untouched++;
                    continue; 
                }
		if ($video['privacy']['view']==='anybody') {}
		else { continue; }    
		    
                if (!$item) {
                $added++;
                $item = collect_vimeo::create();
                $item->setValue('status', 1);
                $item->setValue('title', $video['name']);
                $item->setValue('content', $video['description']);
                $item->setValue('url', $video['link']);
                $item->setValue('preview_image', $video['pictures']['base_link']);
                $item->setValue('publishdate', $video['release_time']);
                $item->setValue('author', $video['user']['name']);
				$item->setValue('raw', json_encode($video));	
                $item->save(); 
			    $preview_name = str_replace("/videos/", "", $video['uri']);					
				if($video['pictures']['base_link']!='') 
				{		
				$file = rex_addon::get('collect')->getDataPath() .'/vimeo/'. $preview_name.'.jpg';
				$filedata = rex_file::get($video['pictures']['base_link']);
                rex_file::put($file, $filedata);
				}	
					
					
				
				}
            else {
                $updated++;
            }
            } 

        } catch (rex_socket_exception $e) {
            $errors[] = $e->getMessage();
        }

        $this->setMessage(sprintf(
            '%d errors%s, %d items added, %d items updated, %d items not changed',
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
            'label' => rex_i18n::msg('collect_video_vimeo_access_token'),
            'name' => 'access_token',
            'type' => 'text',
        ];
        $fields[] = [
            'label' => rex_i18n::msg('collect_video_vimeo_client_id'),
            'name' => 'client_id',
            'type' => 'text',
        ];
        $fields[] = [
            'label' => rex_i18n::msg('collect_video_vimeo_client_secret'),
            'name' => 'client_secret',
            'type' => 'text',
        ];

        return $fields;
    }
}
