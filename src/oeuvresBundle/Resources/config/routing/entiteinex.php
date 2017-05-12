<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('entiteinex', new Route('/', array(
    '_controller' => 'oeuvresBundle:Entiteinex:index',
)));

$collection->add('entiteinex_show', new Route('/{entite}/{id}/show', array(
    '_controller' => 'oeuvresBundle:Entiteinex:show',
)));

return $collection;
