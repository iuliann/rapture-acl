<?php

use Rapture\Acl\Acl;
use Rapture\Acl\Definition\RequesterInterface;
use Rapture\Acl\Definition\ResourceInterface;

class AclTest extends \PHPUnit_Framework_TestCase
{
    public function testPhpAdapter()
    {
        $adapter = new \Rapture\Acl\Adapter\Php();
        $adapter->setDefault(Acl::DENY);

        $adapter->addRule('user', 'resources', Acl::ALL, Acl::ALLOW);
        $adapter->addRule('user', 'resources', Acl::DELETE, Acl::DENY);

        $this->assertTrue($adapter->hasAccess(new RequesterClass(), new ResourceClass(), Acl::EDIT));
        $this->assertFalse($adapter->hasAccess(new RequesterClass(), new ResourceClass(), Acl::DELETE));
    }
}

class RequesterClass implements RequesterInterface
{
    public function requesterGroups()
    {
        return ['user'];
    }

    public function requesterId()
    {
        return 1;
    }
}

class ResourceClass implements ResourceInterface
{
    public function resourceGroups()
    {
        return ['resources'];
    }

    public function resourceId()
    {
        return 0;
    }

    public function ownerId()
    {
        return 1;
    }
}
