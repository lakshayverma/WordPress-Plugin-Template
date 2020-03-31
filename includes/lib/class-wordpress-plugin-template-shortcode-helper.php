<?php

class WordPress_Plugin_Template_ShortCode_Helper {
    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    public function get_option($attributes)
    {
        $defaultAttributes = [
            'option' => null,
            'default' => false,
        ];
        $finalAttributes = shortcode_atts($defaultAttributes, $attributes);

        $value = ($finalAttributes['option'])
            ? get_option($finalAttributes['option'], $finalAttributes['default'])
            : $finalAttributes['default'];


        return $value;
    }

}
