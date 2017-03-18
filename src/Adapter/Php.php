<?php

namespace Rapture\Acl\Adapter;

use Rapture\Acl\Acl;
use Rapture\Acl\Definition\RequesterInterface;
use Rapture\Acl\Definition\ResourceInterface;
use Rapture\Acl\Definition\AdapterInterface;

/**
 * PHP adapter for ACL
 *
 * @package Rapture\Acl
 * @author  Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class Php implements AdapterInterface
{
    /**
     * [requester => [resource => [one-action => allow|disallow]]]
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Bool or Callback which returns bool
     *
     * @var mixed
     */
    protected $default = Acl::DENY;

    /**
     * Use for caching only
     *
     * @param array $rules Array rules
     *
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Add multiple rules
     *
     * @see addRule()
     *
     * @param array $rules Rules
     *
     * @return $this
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $rule += [0, 0, 0, $this->default];
            $this->addRule($rule[0], $rule[1], $rule[2], $rule[3]);
        }

        return $this;
    }

    /**
     * Get processed rules
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Parse rule for fast access
     *
     * @param mixed         $requester String/int for one requester or array for multiple ones
     * @param mixed         $resource  String/int for one resource or array for multiple ones
     * @param int           $action    Bitwise actions
     * @param bool|Callback $access    Whether to allow or disallow actions
     *
     * @return $this
     */
    public function addRule($requester, $resource, $action, $access)
    {
        foreach ((array)$requester as $oneRequester) {
            foreach ((array)$resource as $oneResource) {
                for ($i = 1; $i <= 14; $i++) {
                    $checkAction = pow(2, $i);
                    if ($action & $checkAction) {
                        $this->rules[$oneRequester][$oneResource][$checkAction] = $access;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Set default access mode
     *
     * @param int $default Access mode Action::ALLOW | Action::DENY
     *
     * @return $this
     */
    public function setDefault($default = Acl::DENY)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * hasAccess
     *
     * @param RequesterInterface $requester Requester object
     * @param ResourceInterface  $resource  Resource object
     * @param int                $action    Action to check for
     *
     * @return bool
     */
    public function hasAccess(RequesterInterface $requester, ResourceInterface $resource, $action = Acl::VIEW)
    {
        $resources = (array)$resource->resourceGroups();
        $requesters = (array)$requester->requesterGroups();

        array_unshift($resources, $resource->resourceId());
        array_unshift($requesters, $requester->requesterId());

        $resources[] = Acl::ALL;
        $requesters[] = Acl::ALL;

        if ($requester->requesterId() == $resource->ownerId()) {
            $requesters[] = Acl::OWNER;
        }

        foreach ($resources as $resourceId) {
            foreach ($requesters as $requesterId) {
                if (isset($this->rules[$requesterId][$resourceId][$action])) {
                    $access = $this->rules[$requesterId][$resourceId][$action];

                    return is_callable($access)
                        ? (bool)call_user_func($access, $this)
                        : (bool)$access;
                }
            }
        }

        return (bool)$this->default;
    }
}
