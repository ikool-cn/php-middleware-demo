# php-middleware-demo

	php实现中间件主要通过匿名函数或者__invoke魔术方法来实现。
	对于流程的执行可以起到控制作用，比如我们可以在添加路由后，对某一组路由进行身份验证等。。。
	
```php
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
```
	