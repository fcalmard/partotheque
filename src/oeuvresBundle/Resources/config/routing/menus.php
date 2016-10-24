<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('menus', new Route('/', array(
    '_controller' => 'oeuvresBundle:Menus:index',
)));

$collection->add('menus_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Menus:show',
)));

$collection->add('menus_new', new Route('/new', array(
    '_controller' => 'oeuvresBundle:Menus:new',
)));

$collection->add('menus_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Menus:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('menus_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Menus:edit',
)));

$collection->add('menus_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Menus:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('menus_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Menus:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

return $collection;
