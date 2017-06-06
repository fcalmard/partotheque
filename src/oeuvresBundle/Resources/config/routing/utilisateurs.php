<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('utilisateurs', new Route('/', array(
    '_controller' => 'oeuvresBundle:Utilisateurs:index',
)));

$collection->add('utilisateurs_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Utilisateurs:show',
)));

$collection->add('utilisateurs_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Utilisateurs:new',
)));

$collection->add('utilisateurs_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Utilisateurs:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('utilisateurs_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Utilisateurs:edit',
)));

$collection->add('utilisateurs_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Utilisateurs:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('utilisateurs_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Utilisateurs:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));
$collection->add('utilisateurs_confirm_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Utilisateurs:confirmdelete',
)));


$collection->add('utilisateurs_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Utilisateurs:pagine',
)));
$collection->add('utilisateurs_filtrer', new Route('/{tous}/filtrer', array(
		'_controller' => 'oeuvresBundle:Utilisateurs:filtrer',
)));
return $collection;
