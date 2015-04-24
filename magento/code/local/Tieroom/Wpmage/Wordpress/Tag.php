<?php

require dirname(__FILE__ ) . '/../vendor/CustomTags/TieroomCustomTags.php';

class Tieroom_Wpmage_Wordpress_Tag {

    private $_customTagParser;


    public function __construct () {
	$this->_customTagParser = new TieroomCustomTags(
	    array(
		'tag_name' => 'tr',
		'tag_callback_prefix' => 'tr_',
		'tag_directory' => dirname(__FILE__) . '/../tags/',
		'sniff_for_buried_tags' => true
	    )
	);

    }

    public function parse ($content) {
	return $this->_customTagParser->parse($content);
    }
}