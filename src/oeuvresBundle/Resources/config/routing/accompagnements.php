<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('accompagnements', new Route('/', array(
    '_controller' => 'oeuvresBundle:Accompagnements:index',
)));

$collection->add('accompagnements_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Accompagnements:show',
)));

$collection->add('accompagnements_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Accompagnements:new',
)));

$collection->add('accompagnements_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Accompagnements:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('accompagnements_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Accompagnements:edit',
)));

$collection->add('accompagnements_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Accompagnements:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('accompagnements_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Accompagnements:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('accompagnements_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Accompagnements:confirmdelete',
)));

$collection->add('accompagnements_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Accompagnements:pagine',
)));

return $collection;
