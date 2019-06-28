<?php

namespace App\Controllers;
use Core\BaseController;
use App\Models\Post;
class Posts extends BaseController
{
    
    public function indexAction()
    {
       
      $posts = Post::all();
      
       
    }

    public function addNewAction()
    {
        echo "Hello from PostController's addNew()";
    }

    public function before()
    {
        echo "Before Action <br>";
        return true;
    }
    public function after()
    {
        echo "After Action <br>";
    }
}