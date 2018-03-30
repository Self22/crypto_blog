<?php

namespace App\Helpers;

use App\Exceptions\DuplicateBreadcrumbException;
use App\Exceptions\InvalidBreadcrumbException;
use App\Exceptions\UnnamedRouteException;
use App\Exceptions\ViewNotSetException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Traits\Macroable;
use stdClass;

/**
 * The main Breadcrumbs singleton class, responsible for registering, generating and rendering breadcrumbs.
 */
class BreadcrumbsManager
{
    use Macroable;

    protected $generator;

    protected $router;

    protected $viewFactory;

    protected $callbacks = [];

    protected $before = [];

    protected $after = [];

    protected $route;

    public function __construct(BreadcrumbsGenerator $generator, Router $router, ViewFactory $viewFactory)
    {
        $this->generator   = $generator;
        $this->router      = $router;
        $this->viewFactory = $viewFactory;
    }

    public function register(string $name, callable $callback): void
    {
        if (isset($this->callbacks[ $name ])) {
        
            throw new DuplicateBreadcrumbException("Breadcrumb name \"{$name}\" has already been registered");
        }
        
        $this->callbacks[ $name ] = $callback;
    }

    
    public function before(callable $callback): void
    {
        $this->before[] = $callback;
    }

    public function after(callable $callback): void
    {
        $this->after[] = $callback;
    }

    public function exists(string $name = null): bool
    {
        if (is_null($name)) {
            try {
                [$name] = $this->getCurrentRoute();
            } catch (UnnamedRouteException $e) {
                return false;
            }
        }

        return isset($this->callbacks[ $name ]);
    }

    
    public function generate(string $name = null, ...$params): Collection
    {
        $origName = $name;

        // Route-bound breadcrumbs
        if ($name === null) {
            try {
                [$name, $params] = $this->getCurrentRoute();
            } catch (UnnamedRouteException $e) {
                if (config('breadcrumbs.unnamed-route-exception')) {
                    throw $e;
                }

                return new Collection;
            }
        }

        // Generate breadcrumbs
        try {
            return $this->generator->generate($this->callbacks, $this->before, $this->after, $name, $params);
        } catch (InvalidBreadcrumbException $e) {
            if ($origName === null && config('breadcrumbs.missing-route-bound-breadcrumb-exception')) {
                throw $e;
            }

            if ($origName !== null && config('breadcrumbs.invalid-named-breadcrumb-exception')) {
                throw $e;
            }

            return new Collection;
        }
    }

    
    public function view(string $view, string $name = null, ...$params): HtmlString
    {
        $breadcrumbs = $this->generate($name, ...$params);

        $html = $this->viewFactory->make($view, compact('breadcrumbs'))->render();

        return new HtmlString($html);
    }

    public function render(string $name = null, ...$params): HtmlString
    {
        $view = config('breadcrumbs.view');

        if (! $view) {
            throw new ViewNotSetException('Breadcrumbs view not specified (check config/breadcrumbs.php)');
        }

        return $this->view($view, $name, ...$params);
    }

    
    public function current()
    {
        return $this->generate()->where('current', '!==', false)->last();
    }

    
    protected function getCurrentRoute()
    {
        // Manually set route
        if ($this->route) {
            return $this->route;
        }

        // Determine the current route
        /** @var Router $route */
        $route = $this->router->current();

        // No current route - must be the 404 page
        if ($route === null) {
            return ['errors.404', []];
        }

        // Convert route to name
        $name = $route->getName();

        if ($name === null) {
            $uri = array_first($route->methods()) . ' /' . ltrim($route->uri(), '/');

            throw new UnnamedRouteException("The current route ($uri) is not named");
        }

        // Get the current route parameters
        $params = array_values($route->parameters());

        return [$name, $params];
    }

    public function setCurrentRoute(string $name, ...$params): void
    {
        $this->route = [$name, $params];
    }

    public function clearCurrentRoute(): void
    {
        $this->route = null;
    }
}
