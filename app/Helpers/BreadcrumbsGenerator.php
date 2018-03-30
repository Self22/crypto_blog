<?php

namespace App\Helpers;

use App\Exceptions\InvalidBreadcrumbException;
use Illuminate\Support\Collection;

class BreadcrumbsGenerator
{
    protected $breadcrumbs;

    protected $callbacks = [];

    public function generate(array $callbacks, array $before, array $after, string $name, array $params): Collection
    {
        $this->breadcrumbs = new Collection;
        $this->callbacks   = $callbacks;

        foreach ($before as $callback) {
            $callback($this);
        }

        $this->call($name, $params);

        foreach ($after as $callback) {
            $callback($this);
        }

        return $this->breadcrumbs;
    }

    protected function call(string $name, array $params): void
    {
        if (! isset($this->callbacks[ $name ])) {
            throw new InvalidBreadcrumbException("Breadcrumb not found with name \"{$name}\"");
        }

        $this->callbacks[$name]($this, ...$params);
    }

    public function parent(string $name, ...$params): void
    {
        $this->call($name, $params);
    }

    public function push(string $title, string $url = null, array $data = []): void
    {
        $this->breadcrumbs->push((object) array_merge($data, [
            'title' => $title,
            'url'   => $url,
        ]));
    }
}
