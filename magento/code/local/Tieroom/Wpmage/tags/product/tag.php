<?php

function tr_product($tag) {



    $productSku = $tag['attributes']->sku;

    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $productSku);


    $layout = Mage::getSingleton('core/layout');


    if ($product) {
	$content = '<div class="wpmage-tr-embed wpmage-tr-embed-product">';

	$productBlock = $layout->createBlock('catalog/product')
	    ->setProduct($product)
	    ->setTemplate('catalog/product/view.phtml');

	$content .= $productBlock->toHtml();

	$content .= "</div>";
    } else {
	$content = "";
    }

    return $content;

}
