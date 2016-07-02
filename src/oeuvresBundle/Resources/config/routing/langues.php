<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('langues', new Route('/', array(
    '_controller' => 'oeuvresBundle:Langues:index',
)));

$collection->add('langues_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Langues:show',
)));

$collection->add('langues_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Langues:new',
)));

$collection->add('langues_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Langues:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('langues_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Langues:edit',
)));

$collection->add('langues_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Langues:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('langues_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Langues:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));


$collection->add('langues_confim_delete', new Route('/{id}/confirmdelete', array(
		'_controller' => 'oeuvresBundle:Langues:confirmdelete',
)));

$collection->add('langues_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Langues:pagine',
)));


return $collection;
