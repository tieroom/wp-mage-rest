<?php

require_once "Mage/Cms/controllers/IndexController.php";

class Tieroom_Wpmage_IndexController extends Mage_Cms_IndexController {

    public function _construct () {
	$this->api = new Tieroom_Wpmage_Wordpress_Api();
    }

    public function indexAction($coreRoute = null) {
	$page = $this->api->getPage('home');
	$this->api->renderToView($this, $page);
    }

    public function noRouteAction($coreRoute = null)  {

	$slug = ltrim($_SERVER['REQUEST_URI'], "/");

	if ($this->api->pageExists($slug)) {
	    $page = $this->api->getPage($slug);
	    $this->api->renderToView($this, $page);
	} else {
	    header("Status: 404 Not Found");
	    header('HTTP/1.0 404 Not Found');
	    $page = $this->api->getPage("notfound");
	    $this->api->renderToView($this, $page);
	}

    }
}