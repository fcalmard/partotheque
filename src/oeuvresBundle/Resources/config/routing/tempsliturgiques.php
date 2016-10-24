<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('tempsliturgiques', new Route('/', array(
    '_controller' => 'oeuvresBundle:TempsLiturgiques:index',
)));

$collection->add('tempsliturgiques_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:TempsLiturgiques:show',
)));

$collection->add('tempsliturgiques_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:TempsLiturgiques:new',
)));

$collection->add('tempsliturgiques_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:TempsLiturgiques:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('tempsliturgiques_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:TempsLiturgiques:edit',
)));

$collection->add('tempsliturgiques_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:TempsLiturgiques:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('tempsliturgiques_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:TempsLiturgiques:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));
$collection->add('tempsliturgiques_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:TempsLiturgiques:confirmdelete',
)));
$collection->add('tempsliturgiques_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:TempsLiturgiques:pagine',
)));

return $collection;
