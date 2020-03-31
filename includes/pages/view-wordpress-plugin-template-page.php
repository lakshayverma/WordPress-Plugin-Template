<?php

class WordPress_Plugin_Template_Page implements WordPress_Plugin_Template_Page_Contract
{
    private   $view;
    protected $data;
    protected $scripts;

    public function __construct($view, array $data = null)
    {
        $this->data = $data ?? array();
        $this->setView($view);
    }

    public function renderView()
    {
        echo $this->getRenderContents();

        return $this;
    }

    public function getRenderContents(): string
    {
        $viewContent = null;
        extract($this->getData(), EXTR_OVERWRITE, 'wlk');
        ob_start();
        include $this->getView();
        $viewContent = ob_get_clean();

        return $viewContent;
    }

    public function setViewData(array $data)
    {
        return $this;
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function mergeData (array $dataToBeMerged) : self
    {
        $this->data = array_merge($this->data, $dataToBeMerged);

        return $this;
    }

    /**
     * Get the value of view
     */
    public function getView() : string
    {
        return $this->view;
    }

    /**
     * Set the value of view
     *
     * @return  self
     */
    public function setView($view) : self
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the value of scripts
     */
    public function getScripts() : array
    {
        return $this->scripts;
    }

    /**
     * Set the value of scripts
     *
     * @return  self
     */
    public function setScripts(array $scripts)
    {
        $this->scripts = $scripts;

        return $this;
    }

    public function savesRequest() : bool
    {
        return false;
    }
}
