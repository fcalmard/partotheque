<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('voix', new Route('/', array(
    '_controller' => 'oeuvresBundle:Voix:index',
)));

$collection->add('voix_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Voix:show',
)));

$collection->add('voix_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Voix:new',
)));

$collection->add('voix_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Voix:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('voix_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Voix:edit',
)));

$collection->add('voix_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Voix:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('voix_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Voix:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('voix_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Voix:confirmdelete',
)));

$collection->add('voix_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Voix:pagine',
)));
$collection->add('voix_filtrer', new Route('/{tous}/filtrer', array(
		'_controller' => 'oeuvresBundle:Voix:filtrer',
)));
return $collection;
