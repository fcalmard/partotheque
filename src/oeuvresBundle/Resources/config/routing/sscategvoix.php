<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('sscategvoix', new Route('/', array(
    '_controller' => 'oeuvresBundle:Souscategvoix:index',
)));

$collection->add('sscategvoix_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Souscategvoix:show',
)));

$collection->add('sscategvoix_new', new Route('/{idvoix}/new', array(
    '_controller' => 'oeuvresBundle:Souscategvoix:new',
)));

$collection->add('sscategvoix_create', new Route(
    '/{idvoix}/create',
    array('_controller' => 'oeuvresBundle:Souscategvoix:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('sscategvoix_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Souscategvoix:edit',
)));

$collection->add('sscategvoix_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Souscategvoix:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('sscategvoix_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Souscategvoix:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('sscategvoix_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Souscategvoix:confirmdelete',
)));

$collection->add('sscategvoix_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Souscategvoix:pagine',
)));

return $collection;
