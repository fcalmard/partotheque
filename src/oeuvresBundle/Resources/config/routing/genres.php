<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('genres', new Route('/', array(
    '_controller' => 'oeuvresBundle:Genres:index',
)));

$collection->add('genres_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Genres:show',
)));

$collection->add('genres_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Genres:new',
)));

$collection->add('genres_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Genres:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('genres_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Genres:edit',
)));

$collection->add('genres_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Genres:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('genres_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Genres:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));


$collection->add('genres_confim_delete', new Route('/{id}/confirmdelete', array(
		'_controller' => 'oeuvresBundle:Genres:confirmdelete',
)));

$collection->add('genres_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Genres:pagine',
)));


return $collection;
