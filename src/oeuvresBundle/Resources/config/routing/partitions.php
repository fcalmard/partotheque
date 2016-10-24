<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('partitions', new Route('/{oeuvre_id}/', array(
    '_controller' => 'oeuvresBundle:Partitions:index',
)));

$collection->add('partitions_show', new Route('/{oeuvre_id}/{id}/show', array(
    '_controller' => 'oeuvresBundle:Partitions:show',
)));

$collection->add('partitions_new', new Route('/{oeuvre_id}/new', array(
    '_controller' => 'oeuvresBundle:Partitions:new',
)));

$collection->add('partitions_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Partitions:create'),
    array(),
    array(),
    '',
    array(),
		array('POST','PUT')
));

$collection->add('partitions_create_part', new Route(
		'/{oeuvre_id}/create/partition',
		array('_controller' => 'oeuvresBundle:Partitions:create'),
		array(),
		array(),
		'',
		array(),
		array('POST','PUT','GET')
));


$collection->add('partitions_edit', new Route('/{oeuvre_id}/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Partitions:edit',
)));

$collection->add('partitions_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Partitions:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('partitions_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Partitions:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));
$collection->add('partitions_confirm_action_delete', new Route('/{oeuvre_id}/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Partitions:confirmdelete',
)));
return $collection;
