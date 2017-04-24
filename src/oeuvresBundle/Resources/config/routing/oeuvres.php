<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('oeuvres', new Route('/', array(
    '_controller' => 'oeuvresBundle:Oeuvres:index',
)));

$collection->add('oeuvres_compo', new Route('/{compoid}/compooeuvres', array(
		'_controller' => 'oeuvresBundle:Oeuvres:index',
)));


$collection->add('oeuvres_filtrer', new Route('/{tous}/filtrer', array(
		'_controller' => 'oeuvresBundle:Oeuvres:filtrer',
)));

$collection->add('oeuvres_affiche_filtres', new Route('/filtres', array(
		'_controller' => 'oeuvresBundle:Oeuvres:affichefiltres',
)));

$collection->add('oeuvres_affiche_apppdf', new Route('/apppdf', array(
		'_controller' => 'oeuvresBundle:Oeuvres:afficheapppdf',
)));


$collection->add('oeuvres_trier', new Route('/{tripar}/{ordretri}/trier', array(
		'_controller' => 'oeuvresBundle:Oeuvres:trier',
)));

$collection->add('oeuvres_show', new Route('/{id}/show', array(
		'_controller' => 'oeuvresBundle:Oeuvres:show',
)));

$collection->add('oeuvres_pagine', new Route('/{idxenreg}/{sens}/{action}/pagine', array(
		'_controller' => 'oeuvresBundle:Oeuvres:pagine',
)));

$collection->add('oeuvres_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Oeuvres:new',
)));

$collection->add('oeuvres_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Oeuvres:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('oeuvres_edit', new Route('/{id}/edit', array(
		'_controller' => 'oeuvresBundle:Oeuvres:edit',
)));

$collection->add('oeuvres_confim_delete', new Route('/{id}/confirmdelete', array(
		'_controller' => 'oeuvresBundle:Oeuvres:confirmdelete',
)));

$collection->add('oeuvres_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Oeuvres:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('oeuvres_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Oeuvres:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('oeuvres_confirm_action_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Oeuvres:confirmdelete',
)));

$collection->add('oeuvres_import', new Route(
		'/import',
		array('_controller' => 'oeuvresBundle:Oeuvres:import'),
		array(),
		array(),
		'',
		array(),
		array('POST', 'PUT', 'GET')
		));


$collection->add('oeuvres_exec_import', new Route('/exec_import', array(
		'_controller' => 'oeuvresBundle:Oeuvres:exec_import',
)));
return $collection;
