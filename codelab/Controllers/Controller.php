<?php
namespace Controller;

class Controller
{
    var $controllerName;
    var $controllerMethod;

    public function getControllerAttributes(){
        return["ControllerName" => $this->controllerName,
    "ControllerMethod" => $this->controllerMethod,
    ];
    }
}