<?php

/**
 * @application : Personal Portfolio
 * @author      : CodeByPritam
 * @email       : contact@pritamadak.com
 * @version     : 1.0.0
 */

namespace myproject\app\controller;
use myproject\app\core\Controller;

/**
 * @Class  : SiteController
 * @author : CodeByPritam
 * @namespace : myproject\app\controller
 */

class SiteController extends Controller {

    /**
     * Load and Displays the 'home' page.
     *
     * @return string The rendered 'home' view.
     */
    public function home(): string{
        return $this->render('home', $params = []);
    }

}