<?php
class collect_social_media extends \rex_yform_manager_dataset
{
    public function getName() :string
    {
        return $this->getValue('name');
    }

    public function getUrl() :string
    {
        return $this->getValue('url');
    }
    
    public function getAuthor() :string
    {
        return $this->getValue('author');
    }
    
    public function getContent() :string
    {
        return $this->getValue('content');
    }

    public function getImage() :string
    {
        return $this->getValue('image');
    }

    public function getStatus() :int
    {
        return $this->getValue('status');
    }
    
    public function getRawData() :array
    {
        return json_decode($this->getValue('raw'), true);
    }

    public function getUuid() :string
    {
        return $this->getValue('uuid');
    }

    public function getCreateDate() :string
    {
        return $this->getValue('createdate');
    }
    
    /* TODO
    public function getPublishDate() :string
    {
        return $this->getValue('publishdate');
    }
    */

    public function getUpdateDate() :string
    {
        return $this->getValue('updatedate');
    }

    /*
    public function getUpdateUser() :string
    {
        return $this->getValue('updateuser');
    }

    public function isChangedByUser() :bool
    {
        return (bool) this->getValue('updateuser');
    }
    */
}
