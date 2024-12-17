<?php

class HelloWorldController{

public function showHelloWorld() : void
{

    $helloWorldManager = new HelloWorldManager();
    $message = $helloWorldManager->getHelloWorldMessage();

    $view = new View('Hello World');
    $view->render('helloWorld', ['message' => $message]);
}
}