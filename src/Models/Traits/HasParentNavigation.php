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

        while (($el = $el->getParentNavigation()) !== null) {
            array_unshift($stack, $el->getNavigationLink());
        }

        return array_merge([], ...$stack);
    }
}
