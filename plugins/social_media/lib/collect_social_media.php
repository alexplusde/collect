<?php
class collect_social_media extends \rex_yform_manager_dataset
{
    public static function fetchTwitterByCronjob($params) {
        // reaad and save
    }
    public static function fetchFacebookByCronjob($params) {
        // reaad and save
    }
    public static function fetchInstagramByCronjob($params) {
        // reaad and save
    }
    public function getName() :string
    {
        return $this->getValue('name');
    }
}
