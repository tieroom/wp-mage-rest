<?php

    function tr_category($tag) {

	$content = '<div class="wpmage-tr-embed wpmage-tr-embed-category">';

	$categoryId = $tag['attributes']->id;
	$limit = isset($tag['attributes']->limit) ? $tag['attributes']->limit : 10;
	$inStock = isset($tag['attributes']->instock) ? (bool) $tag['attributes']->instock : true;
	    $columnCount = isset($tag['attributes']->columns) ? (int) $tag['attributes']->columns : 3;
	$viewType = "grid";
	$order = array(
	    'property' => 'name',
	    'direction' => 'asc'
	);

	if (isset($tag['attributes']->thumbnail) && $tag['attributes']->thumbnail == 'false') {
	    $viewType = "list";
	}


	if (isset($tag['attributes']->order)) {
	    //price-asc, price-dsc, alphabetical, random, color%, release date
	    switch (strtolower($tag['attributes']->order)) {
		case "price-asc":
		    $order = array(
			'property' => 'price',
			'direction' => 'asc'
		    );
		    break;
		case "price-dsc":
		case "price-desc":
		    $order = array(
			'property' => 'price',
			'direction' => 'desc'
		    );
		    break;
		case "alphabetical":
		    $order = array(
			'property' => 'name',
			'direction' => 'asc'
		    );
		    break;
		case "random":
		    $order = array(
			'property' => 'name',
			'direction' => 'random'
		    );
		    break;
		case "color":
		    break;
		case "releasedate":
		    break;

	    }
	}


	$productCollection = Mage::getModel('catalog/category')->load($categoryId)->getProductCollection();

	$productCollection->addAttributeToSelect('*');

	if ($inStock) {
	    $productCollection->addAttributeToFilter('status', 1);
	    $productCollection->addAttributeToFilter('visibility', 4);
	}

	$productCollection->setPageSize($limit);

	if ($order['direction'] != 'random') {
	    $productCollection->setOrder(
		$order['property'],
		$order['direction']
	    );
	} else {
	    $productCollection->getSelect()->order(new Zend_Db_Expr('RAND()'));
	}


	$layout = Mage::getSingleton('core/layout');

	$categoryBlock = $layout->createBlock('catalog/product')
	    ->setLoadedProductCollection($productCollection)
		->setColumnCount($columnCount)
	    ->setMode($viewType)
	    ->setTemplate('catalog/product/list.phtml');

	$content .= $categoryBlock->toHtml();

	$content .= "</div>";
	return $content;

    }
