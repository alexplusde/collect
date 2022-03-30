<?php


class rex_yform_value_collect_media extends rex_yform_value_abstract
{
    public function enterObject()
    {
        if ('' == $this->getValue() && !$this->params['send']) {
            $this->setValue($this->getElement('default'));
        }

        if ($this->needsOutput()) {
            $this->params['form_output'][$this->getId()] = $this->parse('value.showvalue.tpl.php');
        }

        $this->params['value_pool']['email'][$this->getName()] = $this->getValue();
    }

    public function getDescription(): string
    {
        return 'collect_media|name|label|defaultwert|notice';
    }

    public function getDefinitions(): array
    {
        return [
            'type' => 'value',
            'name' => 'collect_media',
            'values' => [
                'name' => ['type' => 'name',    'label' => rex_i18n::msg('yform_values_defaults_name')],
                'label' => ['type' => 'text',    'label' => rex_i18n::msg('yform_values_defaults_label')],
                'default' => ['type' => 'text',    'label' => rex_i18n::msg('yform_values_text_default')],
                'notice' => ['type' => 'text',    'label' => rex_i18n::msg('yform_values_defaults_notice')],
            ],
            'description' => rex_i18n::msg('yform_values_collect_media_description'),
            'db_type' => ['text', 'varchar(191)'],
        ];
    }

    public static function getSearchField($params)
    {
        rex_yform_value_text::getSearchField($params);
    }

    public static function getSearchFilter($params)
    {
        return rex_yform_value_text::getSearchFilter($params);
    }

    public static function getListValue($params)
    {

        /* TODO

        if ($params['subject']) {
            return '<img style="width: 40px;" src="'. rex_url::frontend().rex_media_manager::getUrl("collects_list_preview", $files[0]) .'">';
        }

        return "";


        */
        return rex_yform_value_text::getListValue($params);
    }
}
