<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('compositeurs', new Route('/', array(
    '_controller' => 'oeuvresBundle:Compositeurs:index',
)));

$collection->add('compositeurs_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Compositeurs:show',
)));

$collection->add('compositeurs_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Compositeurs:new',
)));

$collection->add('compositeurs_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Compositeurs:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('compositeurs_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Compositeurs:edit',
)));

$collection->add('compositeurs_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Compositeurs:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('compositeurs_delete', new Route(
		'/{id}/delete',
		array('_controller' => 'oeuvresBundle:Compositeurs:Delete'),
		array(),
		array(),
		'',
		array(),
		'POST'
));

$collection->add('compositeurs_confim_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Compositeurs:confirmdelete',
)));

$collection->add('compositeurs_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Compositeurs:pagine',
)));


return $collection;
