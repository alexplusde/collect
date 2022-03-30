<?php
class collect_places extends \rex_yform_manager_dataset
{
    public function getName() :string
    {
        return $this->getValue('name');
    }

    public function getRating() :float
        return (float) $this->getValue('rating');

}
