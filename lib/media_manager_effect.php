<?php

class rex_effect_collect extends rex_effect_abstract
{
    public function execute()
    {
        $filename = $this->media->getMediaFilename();

        if (preg_match('/^(\d+)\.([a-z\-\_]*)\.collect$/', $filename, $match)) {}
        else { 
            return;
        }
        $id = $match[1];
        $table = $match[2];

        $sql = rex_sql::factory()
            ->setTable($table)
            ->setWhere(['id' => $id, 'status' => 1])
            ->select('media');

        if (!$sql->getRows()) {
            return;
        }
        
        $data = $sql->getValue('media');

        if (!$data || !preg_match('@^data:image/(.*?);base64,(.+)$@', $data, $match)) {
            return;
        }

        $img = @imagecreatefromstring(base64_decode($match[2]));

        if (!$img) {
            return;
        }

        $media = $this->media;
        $media->setMediaPath(null);
        $media->setMediaFilename($filename);
        $media->setImage($img);
        $media->setFormat($match[1]);
        $media->setHeader('Content-Type', 'image/'.$match[1]);
        $media->refreshImageDimensions();
    }

    public function getName()
    {
        return rex_i18n::msg('collect_media_manager_effect');
    }
}
