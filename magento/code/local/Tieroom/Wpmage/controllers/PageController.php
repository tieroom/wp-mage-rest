<?php

require_once "Mage/Cms/controllers/PageController.php";


class Tieroom_Wpmage_PageController extends Mage_Cms_PageController {

	//TODO: Check if page exists in Magento/Wordpress, Christian decides how?

    public function _construct () {
	$this->api = new Tieroom_Wpmage_Wordpress_Api();
    }

    public function viewAction($coreRoute = null)  {
	$page = $this->api->getPage(ltrim($_SERVER['REQUEST_URI'], "/"));
	$this->api->renderToView($this, $page);
    }

}