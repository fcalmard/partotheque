<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('avancements', new Route('/', array(
    '_controller' => 'oeuvresBundle:Avancements:index',
)));

$collection->add('avancements_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Avancements:show',
)));

$collection->add('avancements_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Avancements:new',
)));

$collection->add('avancements_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Avancements:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('avancements_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Avancements:edit',
)));

$collection->add('avancements_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Avancements:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('avancements_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Avancements:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('avancements_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Avancements:confirmdelete',
)));
$collection->add('avancements_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Avancements:pagine',
)));

return $collection;
