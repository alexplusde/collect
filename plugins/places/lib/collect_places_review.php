<?php
class collect_places_review extends \rex_yform_manager_dataset
{
    public function getName() :string
    {
        return $this->getValue('name');
    }
}
