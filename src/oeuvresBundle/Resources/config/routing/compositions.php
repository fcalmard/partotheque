<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('compositions', new Route('/', array(
    '_controller' => 'oeuvresBundle:Compositions:index',
)));

$collection->add('compositions_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Compositions:show',
)));

$collection->add('compositions_new', new Route('/{idaccomp}/new', array(
    '_controller' => 'oeuvresBundle:Compositions:new',
)));

$collection->add('compositions_create', new Route(
    '/{idaccomp}/create',
    array('_controller' => 'oeuvresBundle:Compositions:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('compositions_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Compositions:edit',
)));

$collection->add('compositions_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Compositions:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('compositions_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Compositions:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('compositions_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Compositions:confirmdelete',
)));

$collection->add('compositions_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Compositions:pagine',
)));

return $collection;
