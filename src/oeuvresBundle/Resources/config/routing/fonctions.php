<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('fonctions', new Route('/', array(
    '_controller' => 'oeuvresBundle:Fonctions:index',
)));

$collection->add('fonctions_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Fonctions:show',
)));

$collection->add('fonctions_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Fonctions:new',
)));

$collection->add('fonctions_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Fonctions:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('fonctions_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Fonctions:edit',
)));

$collection->add('fonctions_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Fonctions:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('fonctions_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Fonctions:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('fonctions_confim_delete', new Route('/{id}/confirmdelete', array(
		'_controller' => 'oeuvresBundle:Fonctions:confirmdelete',
)));

$collection->add('fonctions_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Fonctions:pagine',
)));
$collection->add('fonctions_filtrer', new Route('/{tous}/filtrer', array(
		'_controller' => 'oeuvresBundle:Fonctions:filtrer',
)));
return $collection;
