<?php

/**
 * @application : Personal Portfolio
 * @author      : CodeByPritam
 * @email       : contact@pritamadak.com
 * @version     : 1.0.0
 */

namespace myproject\app\core;

/**
 * @class  : Request
 * @author : CodeByPritam
 * @namespace : myproject\app\core
 */

class Request {

    /**
     * Retrieves the current request path from the URL.
     *
     * This method extracts the path portion of the URL from the incoming HTTP request.
     * It handles URLs with or without query parameters by trimming off the query string
     * if present. This is useful for routing and handling different endpoints in the
     * application.
     *
     * @return string The request path without any query parameters.
     */
    public function path(): string {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        // Check Position
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    /**
     * Retrieves the HTTP request method in lowercase.
     *
     * This method returns the HTTP request method (e.g., GET, POST, PUT, DELETE)
     * used for the current request, converted to lowercase for consistency.
     * It is useful in handling routing or processing requests based on their type.
     *
     * @return string The HTTP request method in lowercase (e.g., 'get', 'post').
     */
    public function method(): string{
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Checks if the current request method is GET / POST
     *
     * This method compares the current request method with 'get' / 'post' and
     * returns true if they match; otherwise, it returns false.
     *
     * @return bool True if the request method is GET / POST, false otherwise.
     */
    public function isGet(): bool{
        return $this->method() == 'get';
    }

    public function isPost(): bool{
        return $this->method() == 'post';
    }

    /**
     * Retrieves and sanitizes the request body from GET and POST methods.
     *
     * This method collects data from the global `$_GET` and `$_POST` arrays,
     * sanitizing the input to prevent XSS and other injection attacks.
     * The sanitized data is returned as an associative array.
     *
     * It is important to ensure that user input is properly filtered
     * before processing to maintain application security.
     *
     * @return array An associative array containing sanitized input data from the GET or POST request.
     */
    public function GetBody(): array{
        $body = [];

        // Filter GET Request
        if ($this->method() == 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        // Filter POST Request
        if ($this->method() == 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        // Return
        return $body;
    }

}