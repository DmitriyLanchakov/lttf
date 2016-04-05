<?php

class ErrorController extends ControllerBase
{
    function notFoundAction($message)
    {
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(404, "Not Found");

        $this->view->setVar('message', $message);
    }

    function forbiddenAction($message)
    {
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(403, "Forbidden");

        $this->view->setVar('message', $message);
    }

    function genericErrorAction($message)
    {
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(500, "Internal Server Error");

        $this->view->setVar('message', $message);
    }
}
