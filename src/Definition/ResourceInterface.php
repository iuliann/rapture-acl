<?php

namespace Rapture\Acl\Definition;

/**
 * Resource interface
 *
 * @package Rapture\Acl
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
interface ResourceInterface
{
    /**
     * Get the group of the resource. Default should be empty array
     *
     * @return array
     */
    public function resourceGroups();

    /**
     * Get the resource id.
     *
     * Examples for resourceId:
     * class: c:\Demo\Model\MyClass:*
     * class with id: c:\Demo\Model\MyClass:1
     * url u:/demo/url
     * file f:/path/to/file
     *
     * @return string
     */
    public function resourceId();

    /**
     * Get the owner Id for the current resource.
     *
     * @return int
     */
    public function ownerId();
}
