<?php

if (!defined('ABSPATH')) exit;

interface WordPress_Plugin_Template_Page_Contract {
    public function renderView();
    public function getRenderContents() : string;
    public function setData(array $data);
    public function setScripts(array $scripts);
    public function getScripts() : array;

    public function savesRequest() : bool;
}
