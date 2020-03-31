<?php

class WordPress_Plugin_Template_Post_Meta_Helper
{
    protected $parent;
    protected $fields;

    protected $targetTypes;

    protected $title;
    protected $editorSettings;

    protected $boxName;

    public function __construct($parent, $fields, $targetTypes = null, $title = 'Walkwel Rest Fields', $boxName = 'wlk-rest-meta')
    {
        $this->parent = $parent;

        $this->fields = $fields;
        $this->targetTypes = $targetTypes ?? array('post', 'page');
        $this->title = $title;

        $this->boxName = $boxName;

        $this->editorSettings = array(
            'wpautop' => false,
            'media_buttons' => false,
            'textarea_rows' => 20,
            'tabindex' => '',
            'tabfocus_elements' => ':prev,:next',
            'editor_css' => '',
            'editor_class' => 'walkwel-seo-meta',
            'teeny' => false,
            'dfw' => false,
            'tinymce' => false,
            'quicktags' => array(
                'buttons' => ','
            )
        );
    }

    public function register_post_meta()
    {
        $validMetaTypes = array('string', 'boolean', 'integer', 'number');

        foreach ($this->targetTypes as $postType) {
            foreach ($this->fields as $field => $args) {
                $fieldName = $args['name'] ?? $field;


                if (!is_array($args)) {
                    $arguments = array(
                        'show_in_rest' => true,
                        'single' => true,
                        'type' => $args ?? 'string',
                    );
                } elseif (is_array($args)) {
                    unset($args['name']);
                    $arguments = $args;
                    $arguments['show_in_rest'] = $arguments['show_in_rest'] ?? true;
                    $arguments['single'] = $arguments['single'] ?? true;

                    if ($arguments['type'] === 'boolean') {
                        $arguments['type'] = 'string';
                    }
                }

                $arguments['type'] = (in_array($arguments['type'], $validMetaTypes)) ? $arguments['type'] : 'string';

                register_post_meta($postType, $fieldName, $arguments);
            }
        }
    }

    public function add_meta_box()
    {
        add_meta_box($this->boxName, __($this->title, 'walkwel-rest-helper'), array($this, 'display_callback'), $this->targetTypes, 'advanced');
    }

    /**
     * Meta box display callback.
     *
     * @param WP_Post $post Current post object.
     */
    function display_callback($post)
    {
        $booleanOptions = array('no', 'yes');
        ?>
        <div class="lkv-meta-box">
            <?php
                    foreach ($this->fields as $field => $args) {
                        $fieldName = WordPress_Plugin_Template_General_Helper::get_array_value('name', $args, $field);
                        $fieldTitle = WordPress_Plugin_Template_General_Helper::get_array_value('title', $args, ucwords($fieldName));
                        $fieldValue = get_post_meta(get_the_ID(), $fieldName, true);
                        $fieldType = WordPress_Plugin_Template_General_Helper::get_array_value('type', $args, 'string');

                        $fieldDescription = WordPress_Plugin_Template_General_Helper::get_array_value('description', $args, '');
                        if (is_array($fieldDescription) && isset($fieldDescription[$post->post_type])) {
                            $fieldDescription = $fieldDescription[$post->post_type];
                            if ($fieldDescription === 'get-template') {
                                $templateVariables = WordPress_Plugin_Template_SEO_Helper::getTemplateVariablesForType($post->post_type, 'array');
                                $fieldDescription = '';
                                foreach ($templateVariables as $variableThatIsAvailable) {
                                    $functionvar = "'$fieldName' , '$variableThatIsAvailable'";
                                    // $fieldDescription .= '<button type="button" class="wlk-template-variable" onclick="insertAtCaret('.$functionvar.');return false;">'.$variableThatIsAvailable.'</button>';

                                }
                            }
                        }

                        $value = $fieldValue ? $fieldValue : NULL;
                        if ($fieldType === 'code') {
                            ?>
                            <div class="wlk-post-meta wlk-code-editor">
                                <h5><?php echo $fieldTitle; ?></h5>
                                <?php
                                                wp_editor($value, $fieldName, $this->editorSettings);
                                                ?>
                            </div>
                            <?php
                            } elseif ($fieldType === 'boolean') {
                                ?>
                                <div class="wlk-post-meta wlk-string-editor">
                                    <p class="meta-options walkwel-meta-field">
                                        <label for="walkwel-<?php echo $fieldName; ?>"><?php echo $fieldTitle; ?></label>
                                        <select id="walkwel-<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" data-lk="<?= $value ?>">
                                            <?php
                                                            foreach ($booleanOptions as $option) {
                                                                ?>
                                                <option value="<?php echo $option; ?>" <?php echo ($option == $value) ? 'selected' : ''; ?>><?php echo ucwords($option); ?></option>
                                            <?php
                                                            }
                                                            ?>
                                        </select>
                                    </p>
                                </div>
                            <?php
                            } elseif ($fieldType === 'textarea') {
                                ?>
                                <div class="wlk-post-meta wlk-code-editor">
                                <h5><?php echo $fieldTitle; ?></h5>
                                    <?php wp_editor(nl2br($value), $fieldName, $this->editorSettings);?>
                                </div>
                                <?php
                            } else {
                                ?>
                    <div class="wlk-post-meta wlk-string-editor">
                        <p class="meta-options walkwel-meta-field">
                            <label for="walkwel-<?php echo $fieldName; ?>"><?php echo $fieldTitle; ?></label>
                            <input id="walkwel-<?php echo $fieldName; ?>" type="text" name="<?php echo $fieldName; ?>" value="<?php echo esc_attr($value); ?>">
                        </p>
                    </div>
                <?php
                            }
                            ?>
            <?php
                    }
                    ?>
        </div>
        <?php
            }

            /**
             * Save meta box content.
             *
             * @param int $post_id Post ID
             */
            function save_meta_box($post_id)
            {
                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

                foreach ($this->fields as $field => $args) {
                    $fieldName = $args['name'] ?? $field;
                    $type = WordPress_Plugin_Template_General_Helper::get_array_value('type', $args, 'string');

                    if (array_key_exists($fieldName, $_POST)) {
                        $value = (in_array($type, ['code', 'textarea'])) ?  stripslashes_deep($_POST[$fieldName]) : sanitize_text_field($_POST[$fieldName]);
                        update_post_meta($post_id, $fieldName, $value);
                    }
                }
            }

            /*****add buttons in wp_editor***** */
            function custom_quicktags()
            {
                global $post;
                if (isset($post->post_type) && $post->post_type != '') {
                    foreach ($this->fields as $field => $args) {
                        $fieldName = WordPress_Plugin_Template_General_Helper::get_array_value('name', $args, $field);
                        $templateVariables = WordPress_Plugin_Template_SEO_Helper::getTemplateVariablesForType($post->post_type, 'array');
                        foreach ($templateVariables as $variableThatIsAvailable) {
                            if (wp_script_is('quicktags')) {
                                ?>
                                <script type="text/javascript">
                                    QTags.addButton('<?php echo $variableThatIsAvailable; ?>', '<?php echo $variableThatIsAvailable; ?>', custom_wp_editor_attributes, '', '', '', '', '<?php echo $fieldName; ?>');
                                </script>
                                <?php
                            }
                        }
                    }
                } else {
                    if (isset($_GET['page'])) {
                        if ($_GET['page'] == 'wlk-rest-head-meta' || $_GET['page'] == 'wlk-rest-foot-meta') {
                            $universal_type = WordPress_Plugin_Template_Route_Group_Helper::get_available_universal_types();
                            $specific_pages_type = WordPress_Plugin_Template_Route_Group_Helper::get_available_specific_pages_types();
                            $basic_type = WordPress_Plugin_Template_Route_Group_Helper::get_available_basic_types();
                            $advance_type   = WordPress_Plugin_Template_Route_Group_Helper::get_available_wc_attributes();
                            $other_type = WordPress_Plugin_Template_Route_Group_Helper::get_list_types();
                            $allfieldType = array_merge($universal_type, $specific_pages_type, $basic_type, $advance_type, $other_type);

                            foreach ($allfieldType as  $field) {
                                $templateVariables = WordPress_Plugin_Template_SEO_Helper::getTemplateVariablesForType($field['slug'], 'array');
                                foreach ($templateVariables as $variableThatIsAvailable) {
                                    if (wp_script_is('quicktags')) {
                                        ?>
                                        <script type="text/javascript">
                                            QTags.addButton('<?php echo $variableThatIsAvailable; ?>', '<?php echo $variableThatIsAvailable; ?>', custom_wp_editor_attributes, '', '', '', '', '<?php echo $field['option']; ?>');
                                        </script>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }

    function action_woocommerce_update_product_variation($product_get_id)
    {
        foreach ($_REQUEST['variable_post_id'] as $key => $variation_id) {
            update_post_meta($variation_id, '_variation_description', $_REQUEST['variable_description'][$key]);
        }
    }
}
