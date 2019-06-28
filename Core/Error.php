<?php 
namespace Core;


class Error{
public static function errorHandler($level, $file, $line)
{
    if(error_reporting()!=0)
    {
        throw new \ErrorException($message, 0, $level, $file, $line);
    }
}

public static function exceptionHandler($exception)
{
    $status_code = $exception->getCode();
    if($status_code != 404)
    {
        $status_code = 500;
    }
    http_response_code($status_code);
    if(\App\Config::SHOW_ERRORS)
    {
    echo "<h1> Fatal Error </h1>";
    echo "<p> Uncaught exception: ".get_class($exception);
    echo "<p> Message: ".$exception->getMessage()."</p>";
    echo "<p> Stack trace:<pre>".$exception->getTraceAsString()."</pre></p>";
    echo "<p> Thrown in ".$exception->getFile()." on line".$exception->getLine()."</p>";
    } else {
        $log = dirname(__DIR__).'/logs/'.date('d-m-Y').'.text';
        ini_set('error_log',$log);

        $message = "Uncaught exception: ".get_class($exception)."'";
        $message .= "with message".$exception->getMessage()."'";
        $message .="\nStack trace:".$exception->getTraceAsString();
        $message .= "\nThrown in " .$exception->getFile()."on Line : ".$exception->getLine();
        error_log($message);
        // if($status_code = 404)
        // {
        //     echo "<h1> Page not found</h1>";
        // } else 
        //     echo "<h1> An error occured</h1>";
        View::renderTemplate("$status_code.php");
    }
}

}