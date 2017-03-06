<?php

class CheckVarMiddleware {
    function __invoke($foo)
    {
        if($foo == 2) {
            throw new Exception('invoke Exception!');
        }
    }
}

class B {
    public $var;

    function foo($val) {
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

$b = new B();
echo $b->foo(2)->addMiddleware(new CheckVarMiddleware())->addMiddleware(function (){
    if($this->var == 3) {
        throw new Exception('Closure Exception!');
    }
    return $this;
})->run();