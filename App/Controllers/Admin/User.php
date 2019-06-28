<?php

namespace App\Controllers\Admin;
use Core\BaseController;

class User extends BaseController
{
    protected function before()
    {
        return true;
    }
    public function indexAction()
    {
       
        echo '<pre>';
        echo htmlspecialchars(print_r($_GET,true));
        echo '</pre>';
        echo '<pre>';
        echo htmlspecialchars(print_r($this->route_params,true));
        echo '</pre>';
      
        echo "I am admin";
    }

}


