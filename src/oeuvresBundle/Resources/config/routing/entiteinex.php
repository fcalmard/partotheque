<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('entiteinex', new Route('/', array(
		'_controller' => 'oeuvresBundle:Entiteinex:index',
)));
$collection->add('testmailer', new Route('/testmailer', array(
		'_controller' => 'oeuvresBundle:Entiteinex:testmailer',
)));

$collection->add('entiteinex_show', new Route('/{entite}/{id}/show', array(
		'_controller' => 'oeuvresBundle:Entiteinex:show',
)));

$collection->add('erreur_show', new Route('/{message}/erreur_show', array(
		'_controller' => 'oeuvresBundle:Entiteinex:erreur_show',
)));

return $collection;
