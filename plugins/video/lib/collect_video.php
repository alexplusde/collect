<?php
class collect_video extends \rex_yform_manager_dataset
{
    public static function fetchByCronjob($params) {
        // reaad and save
    }
    public function getName() :string
    {
        return $this->getValue('name');
    }
}
