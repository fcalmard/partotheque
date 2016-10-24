<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('typesmusiques', new Route('/', array(
    '_controller' => 'oeuvresBundle:Typesmusiques:index',
)));

$collection->add('typesmusiques_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Typesmusiques:show',
)));

$collection->add('typesmusiques_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Typesmusiques:new',
)));

$collection->add('typesmusiques_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Typesmusiques:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('typesmusiques_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Typesmusiques:edit',
)));

$collection->add('typesmusiques_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Typesmusiques:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('typesmusiques_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Typesmusiques:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));
$collection->add('typesmusiques_confim_delete', new Route('/{id}/confirmdelete', array(
		'_controller' => 'oeuvresBundle:Typesmusiques:confirmdelete',
)));

$collection->add('typesmusiques_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Typesmusiques:confirmdelete',
)));

$collection->add('typesmusiques_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Typesmusiques:pagine',
)));

return $collection;
