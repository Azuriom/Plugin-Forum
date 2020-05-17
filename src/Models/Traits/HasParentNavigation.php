<?php

namespace Azuriom\Plugin\Forum\Models\Traits;

trait HasParentNavigation
{
    public function getParentNavigation()
    {
        return null;
    }

    public function getNavigationLink()
    {
        return null;
    }

    public function getNavigationStack()
    {
        $stack = [];

        $el = $this;
        $parent = null;

        while (($el = $el->getParentNavigation()) !== null) {
            $stack = array_merge($el->getNavigationLink(), $stack);
        }

        return $stack;
    }
}
