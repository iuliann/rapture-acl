<?php
namespace Rapture\Acl\Definition;

use Rapture\Acl\Adapter\Php;

/**
 * Adapter interface
 *
 * @package Rapture\Acl
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
interface AdapterInterface
{
    /**
     * hasAccess
     *
     * @param RequesterInterface $requester Requester object
     * @param ResourceInterface  $resource  Resource object
     * @param int                $action    Action to check for
     *
     * @return bool
     */
    public function hasAccess(RequesterInterface $requester, ResourceInterface $resource, $action = Php::VIEW);
}
