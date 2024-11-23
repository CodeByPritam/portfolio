<?php

/**
 * @application : Personal Portfolio
 * @author      : CodeByPritam
 * @email       : contact@pritamadak.com
 * @version     : 1.0.0
 */

namespace myproject\app\core;

/**
 * @class  : Router
 * @author : CodeByPritam
 * @namespace : myproject\app\core
 */

class Router {

    // Router : Defined Variables
    protected array $routes = [];

    // Router : Defined Typed Property
    public Request  $request;
    public Response $response;

    /**
     * Constructor to initialize the Request and Response objects.
     *
     * This method sets up the core dependencies of the class by accepting
     * the Request and Response objects and assigning them to the respective
     * properties. It ensures that the class has access to the current HTTP
     * request data and can manage the HTTP response.
     *
     * @param Request  $request  The incoming HTTP request object containing
     *                           request data like headers, parameters, and method.
     * @param Response $response The HTTP response object used to construct
     *                           the response to be sent back to the client.
     */
    public function __construct(Request $request, Response $response) {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * Registers a GET / POST route with a conditional flag and its callback handler.
     *
     * This method adds a route to handle HTTP GET / HTTP POST requests and associates it
     * with a callback function, optionally conditioned by a boolean value.
     *
     * @param string   $path      The URL path for the GET / POST request.
     * @param callable $callback  The callback function to handle the request at the specified path.
     *
     * @return void
     */
    public function get(string $path, $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Retrieves / GET the name of the current controller from the URL path.
     *
     * This method extracts the first segment of the request URI to determine
     * the controller being accessed. It assumes that the URL path follows
     * a standard format like '/controller/action', where the first part represents
     * the controller name.
     *
     * @return string The name of the current controller extracted from the URL path.
     */
    public function getController(): string {
        $URIpath = $_SERVER['REQUEST_URI'];
        $URIpath = trim($URIpath, '/');
        $part     = explode('/', $URIpath);
        return $part[0];
    }

    /**
     * Checks if the current controller is in protected route array.
     *
     * A protected route is defined in the application's configuration.
     * This method iterates through the list of protected routes
     * and compares each route with the current controller's path.
     * If a match is found, it returns true; otherwise, it returns false.
     *
     * @return bool True if the current controller is a protected route, false otherwise.
     */
    public function ProtectedRoutes(): bool {
        $protected_routes = Application::$protected_routes;
        $currentController = $this->getController();

        // Check Controller Presence
        for ($i = 0; $i < count($protected_routes); $i++) {
            if (trim($protected_routes[$i], '/') == $currentController) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolves the current request path to an appropriate route and executes the corresponding callback.
     *
     * This method matches the current request path and method against registered routes.
     * It supports various types of callbacks, including string views, array-based controllers,
     * and user-defined functions. If a matching route is found, the associated callback
     * is executed, and the result is returned. If no route matches, a 404 error is rendered.
     *
     * @return string The rendered output from the callback or an error message.
     */
    public function resolve(): string {
        $path   = $this->request->path();
        $method = $this->request->method();

        // iterate Through Routes For Given Method
        foreach ($this->routes[$method] as $routePath => $callback) {
            if (preg_match("#^$routePath$#", $path, $matches)) {

                // Remove The First Element Which Full Match
                array_shift($matches);

                // Routes Protected
//                if (Application::isGuest() && $this->ProtectedRoutes()) {
//                    (new Response)->statusCode(403);
//                    return $this->RenderView("access-denied");
//                } else {

                // Check if callback is_string()
                if (is_string($callback)) {
                    return $this->RenderView($callback);
                }

                // If the callback is_array()
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $method = $callback[1];
                    return call_user_func([$controller, $method], $this->request, $this->response, ...$matches);
                }

                // Call user function
                $result = call_user_func($callback, $this->request, $this->response, ...$matches);
                return is_string($result) ? $result : "An error occurred.";

                // }
            }
        }

        // Return a 404 & error page
        $this->response->setStatusCode(404);
        return $this->RenderView("error-page");
    }

    /**
     * Renders a specified view file with optional parameters.
     *
     * This method captures the output of a view file and returns it as a string.
     * It checks if the view file exists and includes it if found. If the view
     * file does not exist, it sets the response status to 404 and renders
     * an error page.
     *
     * @param string $viewName The name of the view file to render (without the .php extension).
     * @param array  $params   An associative array of parameters to pass to the view.
     *
     * @return string The rendered view output as a string.
     */
    public function RenderView(string $viewName, array $params = []): string {

        // iterate through value params
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        if(file_exists(Application::$rootpath . "/app/views/" . $viewName . ".php")) {
            if (Application::$appConstruction) {
                require_once Application::$rootpath . "/app/views/construction.php";
            } else {
                require_once Application::$rootpath . "/app/views/$viewName.php";
            }
        } else {
            $this->response->setStatusCode(404);
            return $this->RenderView('error-page');
        }
        return ob_get_clean();
    }

}