<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('profils', new Route('/', array(
    '_controller' => 'oeuvresBundle:Profils:index',
)));

$collection->add('profils_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Profils:show',
)));

$collection->add('profils_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Profils:new',
)));

$collection->add('profils_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Profils:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('profils_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Profils:edit',
)));

$collection->add('profils_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Profils:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('profils_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Profils:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

$collection->add('profils_confirm_delete', new Route('/{id}/confirm_delete', array(
		'_controller' => 'oeuvresBundle:Profils:confirmdelete',
)));


return $collection;
