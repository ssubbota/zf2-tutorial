<?php

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

$acl = new Acl();

$acl->addRole(new Role('guest'))
    ->addRole(new Role('3'));

$acl->addResource(new Resource('home'));
$acl->addResource(new Resource('album'));
$acl->addResource(new Resource('company'));
$acl->addResource(new Resource('branch'));

$acl->allow('guest', array('home', 'album'));
$acl->allow('3', 'company');
$acl->allow('3', 'branch');
