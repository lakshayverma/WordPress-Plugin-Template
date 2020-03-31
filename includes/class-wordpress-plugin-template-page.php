<?php

if (!defined('ABSPATH')) exit;

class WordPress_Plugin_Template_Rest_Page
{
    protected   $parent;
    private     $page_title;
    private     $menu_title;
    private     $capability;
    private     $slug;
    private     $icon;
    private     $position;
    private     $type;

    private     $render;

    public function __construct($parent, $pageTitle, $capabilty, $slug, $icon = '', $position = null, $menuTitle = null, $type = 'menu', $base = 'wlk_')
    {
        $this->parent = $parent;
        $this->base   = $base;

        $this->setPageTitle($pageTitle);
        $this->setMenuTitle($menuTitle ?? $pageTitle);
        $this->setCapability($capabilty);
        $this->setSlug($slug);

        $this->setIcon($icon);
        $this->setPosition($position);
        $this->setType($type);
    }

    public function setupAdminPage()
    {
        $menuFunction = $this->getMenuFunction();

        $menuFunction(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->slug,
            array($this, 'page_contents'),
            $this->icon,
            $this->position
        );
    }

    public function page_contents ()
    {
        $this->getRender()->renderView();
    }

    /**
     * Get the value of page_title
     */
    public function getPageTitle()
    {
        return $this->page_title;
    }

    /**
     * Set the value of page_title
     *
     * @return  self
     */
    public function setPageTitle($page_title)
    {
        $this->page_title = $page_title;

        return $this;
    }

    /**
     * Get the value of menu_title
     */
    public function getMenutitle()
    {
        return $this->menu_title;
    }

    /**
     * Set the value of menu_title
     *
     * @return  self
     */
    public function setMenuTitle($menu_title)
    {
        $this->menu_title = $menu_title;

        return $this;
    }

    /**
     * Get the value of capability
     */
    public function getCapability()
    {
        return $this->capability;
    }

    /**
     * Set the value of capability
     *
     * @return  self
     */
    public function setCapability($capability)
    {
        $this->capability = $capability;

        return $this;
    }

    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the value of icon
     *
     * @return  self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the value of position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the value of position
     *
     * @return  self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of render
     */
    public function getRender() : WordPress_Plugin_Template_Page_Contract
    {
        return $this->render;
    }

    /**
     * Set the value of render
     *
     * @return  self
     */
    public function setRender(WordPress_Plugin_Template_Page_Contract $render) : self
    {
        $this->render = $render;
        $render->mergeData($this->toArray());

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type) : self
    {
        if (in_array($type, array_keys(static::getAvailablePageTypes()))) {
            $this->type = $type;
        }

        return $this;
    }

    public function getMenuFunction ()
    {
        $pageTypes = static::getAvailablePageTypes();

        return $pageTypes[$this->type];
    }

    public function toArray ()
    {
        $data = [
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
            'capability' => $this->capability,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'position' => $this->position,
            'type' => $this->type,
        ];

        return $data;
    }

    /**
     * Possible Values
     * menu            Adds a menu under Admin menu
     * posts           Adds a submenu under Posts menu
     * pages           Adds a submenu under Pages menu
     * media           Adds a submenu under Media menu
     * comments        Adds a submenu under Comments menu
     * theme           Adds a submenu under the Appearance menu
     * plugin          Adds a submenu under Plugins menu
     * users           Adds a submenu under Users menu
     * management      Adds a submenu under Tools menu
     * options         Adds a submenu under Settings menu
     *
     * @return array
     */
    static public function getAvailablePageTypes () : array
    {
        return [
            'menu' => 'add_menu_page',
            'posts' => 'add_posts_page',
            'pages' => 'add_pages_page',
            'media' => 'add_media_page',
            'comments' => 'add_comments_page',
            'theme' => 'add_theme_page',
            'plugin' => 'add_plugin_page',
            'users' => 'add_users_page',
            'management' => 'add_management_page',
            'options' => 'add_options_page',
        ];
    }
}
