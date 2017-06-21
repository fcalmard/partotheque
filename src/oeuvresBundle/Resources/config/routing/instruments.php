<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('instruments', new Route('/', array(
    '_controller' => 'oeuvresBundle:Instruments:index',
)));

$collection->add('instruments_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Instruments:show',
)));

$collection->add('instruments_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Instruments:new',
)));

$collection->add('instruments_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Instruments:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('instruments_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Instruments:edit',
)));

$collection->add('instruments_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Instruments:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('instruments_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Instruments:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('instruments_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Instruments:confirmdelete',
)));

$collection->add('instruments_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Instruments:pagine',
)));
$collection->add('instruments_filtrer', new Route('/{tous}/filtrer', array(
		'_controller' => 'oeuvresBundle:Instruments:filtrer',
)));
return $collection;
