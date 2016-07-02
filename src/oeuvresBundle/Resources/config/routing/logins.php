<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('logins', new Route('/', array(
    '_controller' => 'oeuvresBundle:Logins:index',
)));

$collection->add('mdpperdu', new Route('/mdpperdu', array(
		'_controller' => 'oeuvresBundle:Logins:mdpperdu',
		array(),
		array(),
		'',
		array(),
		'POST')));


$collection->add('sendnewmdp', new Route('{email}/sendnewmdp', array(
		'_controller' => 'oeuvresBundle:Logins:sendnewmdp',
		array(),
		array(),
		'',
		array(),
		'POST'		
)));

$collection->add('logins_show', new Route('/{id}/show', array(
    '_controller' => 'oeuvresBundle:Logins:show',
)));

$collection->add('logins_new', new Route('/new', array(
		'_controller' => 'oeuvresBundle:Logins:new',
)));
$collection->add('logins_message', new Route('/{message}/message', array(
		'_controller' => 'oeuvresBundle:Logins:message',
)));

$collection->add('logins_unlog', new Route('/unlog', array(
		'_controller' => 'oeuvresBundle:Logins:unlog',
)));

$collection->add('logins_create', new Route(
    '/create',
    array('_controller' => 'oeuvresBundle:Logins:create'),
    array(),
    array(),
    '',
    array(),
    'POST'
));

$collection->add('logins_edit', new Route('/{id}/edit', array(
    '_controller' => 'oeuvresBundle:Logins:edit',
)));

$collection->add('logins_update', new Route(
    '/{id}/update',
    array('_controller' => 'oeuvresBundle:Logins:update'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'PUT')
));

$collection->add('logins_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'oeuvresBundle:Logins:delete'),
    array(),
    array(),
    '',
    array(),
    array('POST', 'DELETE')
));

return $collection;
