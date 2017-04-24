<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('tessitures', new Route('/', array(
    '_controller' => 'oeuvresBundle:Tessitures:index',
)));

$collection->add('legende', new Route('/legende', array(
		'_controller' => 'oeuvresBundle:Tessitures:index',
)));


$collection->add('tessitures_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Tessitures:show',
)));


return $collection;
