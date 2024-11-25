<?php

/**
 * @application : Personal Portfolio
 * @author      : CodeByPritam
 * @email       : contact@pritamadak.com
 * @version     : 1.0.0
 */

namespace myproject\app\core;

/**
 * @Class  : Controller
 * @author : CodeByPritam
 * @namespace : myproject\app\core
 */

class Controller {

    /**
     * Renders a specified view with given parameters.
     *
     * @param  string $view The name of the view file to render.
     * @param  array  $params An associative array of parameters to be passed to the view.
     * @return string The rendered view as a string.
     */
    public function render(string $view, array $params = []): string{
        return Application::$app->router->RenderView($view, $params);
    }

}