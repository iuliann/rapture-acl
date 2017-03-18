# Rapture ACL

[![PhpVersion](https://img.shields.io/badge/php-5.4-orange.svg?style=flat-square)](#)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](#)


## About

Rapture-ACL is an simple authorization layer library for PHP.

Simple concept: `REQUESTER` wants to do an `ACTION` on a `RESOURCE`.


## Requirements

- php v5.4


## Install

```bash
composer require iuliann/rapture-acl
```


## Quick start

### Requester vs Resource

An User (requester) wants to edit (action) a model (resource).

```php
class User implements \Rapture\Acl\Definition\RequesterInterface
{
    /**
     * @return array
     */
    public function requesterGroups()
    {
        return ['admin'];
    }

    /**
     * @return int
     */
    public function requesterId()
    {
        return $this->id;
    }
}
```

```php
class Model implements \Rapture\Acl\Definition\ResourceInterface
{
    /**
     * @return array
     */
    public function resourceGroups()
    {
        return ['models'];
    }

    /**
     * @return string|int
     */
    public function resourceId()
    {
        return $this->getId();
    }

    /**
     * @return int
     */
    public function ownerId()
    {
        return $this->getCreatedBy();
    }
}
```

### Available Actions

```php
class Acl
{
    // resource, requester, owner
    const ANY   = '*';
    const OWNER = '@';

    // access
    const ALLOW = true;
    const DENY = false;

    // actions
    const VIEW = 2;         // 2^1
    const SEARCH = 4;       // 2^2
    const ADD = 8;          // 2^3
    const EDIT = 16;        // 2^4
    const DELETE = 32;      // 2^5
    const UNDO = 64;        // 2^6
    const RENAME = 128;     // 2^7
    const DESTROY = 256;    // 2^8
    const ACTION1 = 512;    // 2^9
    const ACTION2 = 1024;   // 2^10
    const ACTION3 = 2048;   // 2^11
    const ACTION4 = 4096;   // 2^12
    const ACTION5 = 8192;   // 2^13

    const ALL = 16382;
}
```


### Usage

```php
$adapter = new \Rapture\Acl\Adapter\Php();
$adapter->setDefault(\Rapture\Acl\Acl::DENY);

$rules = [
    //  requester - resource - actions (optional) - allow (optional)

    // allow admins to all resources to ALL actions
    ['admin', Acl::ANY, Acl::ALL, Acl::ALLOW],

    // allow guest to view specific resources
    ['guest', 'resource-x', Acl::VIEW, Acl::ALLOW],
];
$adapter->addRules($rules);

$adapter->hasAccess(new Requester, new Resource, Acl::EDIT);
```



## About

### Author

Iulian N. `rapture@iuliann.ro`

### Testing

```
cd ./test && phpunit
```

### Credits

- [http://phpgacl.sourceforge.net/](http://phpgacl.sourceforge.net/)
- [http://phpgacl.sourceforge.net/manual.pdf](http://phpgacl.sourceforge.net/manual.pdf)

### License

Rapture PHP ACL is licensed under the MIT License - see the `LICENSE` file for details.
