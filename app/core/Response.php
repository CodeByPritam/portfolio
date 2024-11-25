<?php

/**
 * @application : Personal Portfolio
 * @author      : CodeByPritam
 * @email       : contact@pritamadak.com
 * @version     : 1.0.0
 */

namespace myproject\app\core;

/**
 * @class  : Response
 * @author : CodeByPritam
 * @namespace : myproject\app\core
 */

class Response {

    /**
     * Sets the HTTP response status code.
     *
     * This method updates the HTTP status code of the response to the specified value.
     * It is useful for indicating the result of the HTTP request, such as 200 for success,
     * 404 for not found, or 500 for server errors.
     *
     * @param int $code The HTTP status code to be set (e.g., 200, 404, 500).
     */
    public function setStatusCode(int $code): void{
        http_response_code($code);
    }

    /**
     * Redirects the user to a specified URL.
     *
     * This method sends an HTTP header to the client, instructing it to
     * navigate to a different location. It is commonly used after form
     * submissions, or when access to a certain page is restricted.
     *
     * @param string $loc The target URL to which the user will be redirected.
     */
    public function redirect(string $loc): void{
        header('Location: ' . $loc);
    }

}