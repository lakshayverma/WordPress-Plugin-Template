<?php
defined('ABSPATH') || exit;


class WordPress_Plugin_Template_General_Helper {
    public static function get_array_value($key, $array, $default = null)
    {
        if ((is_string($key) || is_integer($key)) && is_array($array) && array_key_exists($key, $array)) {
            return $array[$key];
        } else {
            return $default;
        }
    }

    public static function get_array_value_db_safe($key, $array, $default = null)
    {
        $value = static::get_array_value($key, $array, $default);
        if (is_array($value)) {
            $data = [];

            foreach ($value as $inputName => $input) {
                $data[sanitize_text_field($inputName)] = sanitize_text_field($input);
            }
        } else {
            $data = sanitize_text_field($value);
        }

        return $data;
    }
}

class WordPress_Plugin_Template_Config {
    const TAXONOMY_SLUG_PRODUCT = 'product';
    const TAXONOMY_SLUG_PRODUCT_CAT = 'product_cat';
    const TAXONOMY_SLUG_PRODUCT_TAG = 'product_tag';
}
