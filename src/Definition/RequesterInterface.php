<?php

namespace Rapture\Acl\Definition;

/**
 * Requester interface
 *
 * @package Rapture\Acl
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
interface RequesterInterface
{
    /**
     * Get the requester role(s) id(s).
     *
     * @return array
     */
    public function requesterGroups();

    /**
     * Get the requester id.
     *
     * @return int
     */
    public function requesterId();
}
