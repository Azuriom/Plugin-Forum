<?php

namespace Azuriom\Plugin\Forum\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasParentNavigation
{
    public function getParentNavigation(): ?Model
    {
        return null;
    }

    public function getNavigationLink(): array
    {
        return [];
    }

    public function getNavigationStack(): array
    {
        $stack = [];

        $el = $this;

        while (($el = $el->getParentNavigation()) !== null) {
            array_unshift($stack, $el->getNavigationLink());
        }

        return array_merge([], ...$stack);
    }
}
