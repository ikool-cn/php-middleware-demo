# php-middleware-demo

	php实现中间件主要通过匿名函数或者__invoke魔术方法来实现。
	对于流程的执行可以起到控制作用，比如我们可以在添加路由后，对某一组路由进行身份验证等。。。
	
```php
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
```
	