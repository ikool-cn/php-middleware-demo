<?php

class CheckVarMiddleware {
    function __invoke($var)
    {
        if($var == 'foo') {
            throw new Exception('invoke Exception!');
        }
    }
}

class App {
    public $var;

    function setVar($val) {
        $this->var = $val;
        return $this;
    }

    function run() {
        return $this->var;
    }

    function addMiddleware(callable $callable) {
        if($callable instanceof Closure) {
            $callable->call($this);
        }else {
            $callable($this->var);
        }
        return $this;
    }
}

$app = new App();
echo $app->setVar('demo')->addMiddleware(new CheckVarMiddleware())->addMiddleware(function (){
    if($this->var == 'bar') {
        throw new Exception('Closure Exception!');
    }
    return $this;
})->run();