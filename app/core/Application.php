<?php

/**
 * @application : Personal Portfolio
 * @author      : CodeByPritam
 * @email       : contact@pritamadak.com
 * @version     : 1.0.0
 */

namespace myproject\app\core;

/**
 * @class  : Application
 * @author : CodeByPritam
 * @namespace : myproject\app\core
 */

class Application {

    // Application : Defined Variables
    public static string $appConstruction;
    public static string $rootpath;
    public static string $domainName;
    public static string $loginStatus;
    public static array  $protected_routes;

    // Application : Typed Property
    public static Application $app;
    public Router   $router;
    public Request  $request;
    public Response $response;

    /**
     * Initializes a new instance of the Application Class with the given root directory and configuration.
     *
     * This constructor sets up the application by initializing necessary components such as
     * request and response handlers, the router, database connection, and session management.
     * It also checks the user's login status and retrieves the user instance if logged in.
     *
     * @param string $rootpath The root directory path of the application.
     * @param array  $config Configuration array containing application settings.
     */
    public function __construct(string $rootpath, array $config){
        self::$appConstruction  = $config['isConstruction'];
        self::$rootpath         = $rootpath;
        self::$domainName       = $this->myURI();
        self::$app              = $this;
        self::$loginStatus      = false;
        $this->request          = new Request();
        $this->response         = new Response();
        $this->router           = new Router($this->request, $this->response);
    }

    /*
     * Retrieves the base URI of the current server request.
     *
     * This method constructs the base URL by determining the protocol
     * (HTTP or HTTPS) and combining it with the host name. It is useful
     * for generating absolute URLs that are protocol-aware.
     *
     * @return string The base URI in the format 'protocol://host',
     */
    public function myURI(): string {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . '://' . $host;
    }

    /**
     * Executes the main application logic.
     *
     * This method triggers the router to resolve the incoming request
     * and outputs the resulting response. It serves as the entry point
     * for handling all HTTP requests within the application.
     */
    public function run(): void{
        echo $this->router->resolve();
    }

}