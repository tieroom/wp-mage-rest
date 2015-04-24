<?php

class Tieroom_Wpmage_Wordpress_Api {

    public $config = array(
        'host' => "http://wp.tieroom.dev:8888/wordpress"
    );

    public $custom_attributes = array(
        '_yoast_wpseo_metadesc',
        '_yoast_wpseo_title',
        '_yoast_wpseo_focuskw',
        '_yoast_wpseo_meta-robots-noindex',
        '_yoast_wpseo_meta-robots-nofollow',
        '_yoast_wpseo_redirect',
        '_yoast_wpseo_canonical',
        '_yoast_wpseo_google-plus-description',
        '_yoast_wpseo_opengraph-image',
        '_yoast_wpseo_opengraph-description',
        '_yoast_wpseo_sitemap-html-include',
        '_yoast_wpseo_sitemap-prio',
        '_yoast_wpseo_sitemap-include',
        '_yoast_wpseo_meta-robots-adv',
        '_yoast_wpseo_authorship',
        '_tieroom'
    );

    public function __construct () {
        $this->api_base = $this->config['host'] . "/api/get_page/?slug=%s&custom_fields=" . implode(",", $this->custom_attributes);
        $this->tagParser = new Tieroom_Wpmage_Wordpress_Tag();
    }

    public function get_url ($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        return $output;
    }

    public function pageExists ($slug) {

        $exists = false;

        $url = sprintf($this->api_base, $slug);

        $json = json_decode(
            $this->get_url($url),
            true
        );

        if ($json['status'] == 'ok') {
            $exists = true;
        }

        return $exists;
    }

    private function hasCustomAttribute ($attribute_name) {
        if (!$this->page || !$this->custom_fields) {
            return false;
        }

        return (
            array_key_exists($attribute_name, $this->custom_fields) &&
            is_array($this->custom_fields[$attribute_name]) &&
            sizeof($this->custom_fields[$attribute_name]) > 0
        );
    }

    public function getPage($slug) {

        $url = sprintf($this->api_base, $slug);

        $json = json_decode(
            $this->get_url($url),
            true
        );

        $this->page = array();

        if ($json['status'] == 'ok' && $json['page']['status'] == 'publish') {
            $this->page = $json['page'];


            //Create a description property to keep excerpt intact
            $this->page['description'] = $this->page['excerpt'];
            $this->page['content'] = $this->tagParser->parse($this->page['content']);

            if (array_key_exists('custom_fields', $this->page) && is_array($this->page['custom_fields'])) {
                $this->custom_fields = $this->page['custom_fields'];

                foreach ($this->custom_attributes as $custom_attribute) {
                    if ($this->hasCustomAttribute($custom_attribute)) {
                        $keyName = str_replace('_yoast_wpseo_', '', $custom_attribute);
                        $this->page[$keyName] = $this->custom_fields[$custom_attribute][0];
                    }
                }
            }

        }

        return $this->page;

    }

    public function renderToView ($controller, $data, $layoutName = 'wpmage_page_layout', $blockName = 'wpmage_page', $context = 'page') {
        $controller->loadLayout($layoutName);

        $pageBlock = $controller->getLayout()->getBlock($blockName);

        if (array_key_exists('metadesc', $data)) {
            $data['description'] = $data['metadesc'];
        }

        if (array_key_exists('_tieroom', $data)) {
            $data['tieroom'] = unserialize($data['_tieroom']);
        }


        if ($pageBlock) {
            $pageBlock->assign($context, $data);
        }

        $headBlock = $controller->getLayout()->getBlock('head');

        $headBlock->setTitle($data['title']);
        $headBlock->setDescription($data['description']);


        if (array_key_exists('meta-robots-noindex', $data) || array_key_exists('meta-robots-nofollow', $data)) {

            $robots = array();

            if (array_key_exists('meta-robots-noindex', $data) && $data['meta-robots-noindex'] == '1') {
                $robots[] = 'noindex';
            }

            if (array_key_exists('meta-robots-nofollow', $data) && $data['meta-robots-nofollow'] == '1') {
                $robots[] = 'nofollow';
            }

            $headBlock->setRobots(implode(',', $robots));
        }

        $controller->renderLayout();
    }
}