<?php
namespace App\Controllers;
use Core\BaseController;
use Core\View;
use App\Models\Post;

class Home extends BaseController
{
    public function index()
    {
    //    View::render('Home/index.php', [ 'name'=>'sujeet', 'id'=>23434]);
    $post = Post::find(1);

    View::renderTemplate('Home/index.html',['post'=>$post]);
    }
}