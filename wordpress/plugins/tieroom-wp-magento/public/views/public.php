<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
?>

<textarea id="_tieroom_custom_css" class="large-text" placeholder="Custom CSS" name="_tieroom[custom_css]" cols="80" rows="10"><?php if(!empty($meta['custom_css'])) echo $meta['custom_css']; ?></textarea>
