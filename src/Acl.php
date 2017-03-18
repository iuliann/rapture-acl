<?php

namespace Rapture\Acl;

/**
 * Class Acl
 *
 * @package Rapture\Acl
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Acl
{
    // resource, requester, owner
    const ANY = '*';
    const OWNER = '@';

    // access
    const ALLOW = 1;
    const DENY = 0;

    // actions
    const VIEW = 2;      // 2^1
    const SEARCH = 4;      // 2^2
    const ADD = 8;      // 2^3
    const EDIT = 16;     // 2^4
    const DELETE = 32;     // 2^5
    const UNDO = 64;     // 2^6
    const RENAME = 128;    // 2^7
    const DESTROY = 256;    // 2^8
    const ACTION1 = 512;    // 2^9
    const ACTION2 = 1024;   // 2^10
    const ACTION3 = 2048;   // 2^11
    const ACTION4 = 4096;   // 2^12
    const ACTION5 = 8192;   // 2^13

    const ALL = 16382;
}
