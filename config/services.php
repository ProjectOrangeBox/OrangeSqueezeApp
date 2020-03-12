<?php

return [
	'data' => [function ($container) {
		$config = ['sessionService' => $container->session];
		return new \projectorangebox\data\Data($config);
	}],
	'log' => [function ($container) {
		$config = $container->config->get('logger', []);
		return new \projectorangebox\log\Logger($config);
	}],
	'config' => [function () {
		return new \projectorangebox\config\Config();
	}],
	'models' => [function ($container) {
		$config = $container->config->get('models', []);

		$config['validateService'] = $container->validate;
		$config['connections'] = $container->config->get('connections', []);

		return new \projectorangebox\models\Models($config);
	}],
	'auth' => [function ($container) {
		$config = $container->config->get('auth', []);

		$config['db'] = $container->pdoDefault;

		return new \projectorangebox\auth\Auth($config);
	}],
	'user' => [function ($container) {
		$config = $container->config->get('auth', []);

		$config['authService'] = $container->auth;
		$config['sessionService'] = $container->session;
		$config['cacheService'] = $container->cache;

		$config['db'] = $container->pdoDefault;

		return new \projectorangebox\user\User($config);
	}],
	'pdoDefault' => [function ($container) {
		$config = $container->config->get('connections.default database', []);

		return new \PDO($config['type'] . ':dbname=' . $config['name'] . ';host=' . $config['server'], $config['username'], $config['password']);
	}],
	'viewresponse' => [function ($container) {
		$config = $container->config->get('viewresponse', []);

		/* auto detect request type and set a few things in the config */
		if ($container->request->isCli()) {
			$config['type'] = 'cli';
			$config['format file prefix'] = '//formats/cli/';
		} elseif ($container->request->isAjax()) {
			$config['type'] = 'ajax';
			$config['format file prefix'] = '//formats/ajax/';
		} else {
			$config['type'] = 'html';
			$config['format file prefix'] = '//formats/html/';
		}

		$config['viewService'] = $container->view;
		$config['responseService'] = $container->response;

		return new \projectorangebox\viewresponse\ViewResponse($config);
	}],
	'session' => [function ($container) {
		$config = $container->config->get('session', []);
		return new \projectorangebox\session\Session($config);
	}],
	'router' => [function ($container) {
		$config = $container->config->get('router', []);

		/* reformat the routes */
		$config['routes'] = cache('app.routes', function () use ($config) {
			return \projectorangebox\router\RouterBuilder::build($config);
		});

		return new \projectorangebox\router\Router($config);
	}],
	/* create new each time */
	'validate' => [function ($container) {
		$config = $container->config->get('validate', []);

		$config['rules'] = cache('validation_rules', function () use ($config) {
			return \projectorangebox\validation\RuleFinder::search($config['search']);
		});

		$config['filterService'] = $container->filter;

		return new \projectorangebox\validation\Validate($config);
	}, false],
	'filter' => [function ($container) {
		$config = $container->config->get('filter', []);

		$config['rules'] = cache('filter_rules', function () use ($config) {
			return \projectorangebox\filter\FilterFinder::search($config['search']);
		});

		return new \projectorangebox\filter\Filter($config);
	}],
	'cache' => [function ($container) {
		$config = $container->config->get('cache', []);
		return new \projectorangebox\cache\Cache($config);
	}],
	'dispatcher' => [function ($container) {
		$config['container'] = &$container;
		$config['routerService'] = $container->router;
		$config['requestService'] = $container->request;
		$config['responseService'] = $container->response;

		return new \projectorangebox\dispatcher\Dispatcher($config);
	}],
	'middleware' => [function ($container) {
		$config = $container->config->get('middleware', []);

		$config['default'] = ['get', 'cli', 'post', 'put', 'delete'];

		$config['request'] = cache('app.request.middleware', function () use ($config) {
			$config['routes'] = $config['request'];
			return \projectorangebox\router\RouterBuilder::build($config);
		});

		$config['response'] = cache('app.response.middleware', function () use ($config) {
			$config['routes'] = $config['response'];
			return \projectorangebox\router\RouterBuilder::build($config);
		});

		$config['containerService'] = &$container;

		return new \projectorangebox\middleware\handler\Middleware($config);
	}],
	'forker' => [function ($container) {
		$config = $container->config->get('forker', []);
		return new \projectorangebox\forker\Forker($config);
	}],
	'request' => [function ($container) {
		$config = $container->config->get('request', []);
		return new \projectorangebox\request\Request($config);
	}],
	'response' => [function ($container) {
		$config = $container->config->get('response', []);
		return new \projectorangebox\response\Response($config);
	}],
	'responseStream' => [function ($container) {
		$config = $container->config->get('response', []);

		$config['is cli'] = $container->request->isCli();

		return new \projectorangebox\response\ResponseStream($config);
	}],
	'responseCached' => [function ($container) {
		$config = $container->config->get('response', []);

		$config['cacheService'] = $container->cache;
		$config['uri'] = $container->request->uri();

		return new \projectorangebox\response\ResponseCached($config);
	}],
	'html' => [function ($container) {
		$config = $container->config->get('html', []);
		return new \projectorangebox\html\Html($config);
	}],
	'pear_helper' => [function ($container) {
		$config = $container->config->get('pear', []);

		$config['plugins'] = cache('pear.plugins', function () use ($config) {
			return \projectorangebox\pear\PluginFinder::search($config['search']);
		});

		return new \projectorangebox\pear\PearHelper($config);
	}],
	'view' => [function ($container) {
		/* load in "search" order first is "default" */
		$viewConfig = $container->config->get('view', []);

		/* Page Parser */
		$parserConfig = $container->config->get('parser_page', []);

		$parserConfig['views'] = cache('page.views', function () use ($parserConfig) {
			return \projectorangebox\view\ViewFinder::search($parserConfig['search']);
		});

		$parserConfig['default view'] = trim($container->request->uri(), '/');

		$viewConfig['parsers']['page'] = new \projectorangebox\parser\page\Page($parserConfig);

		/* Default PHP Parser */
		$parserConfig = $container->config->get('view.php', []);

		$parserConfig['views'] = cache('php_views', function () use ($parserConfig) {
			return \projectorangebox\view\ViewFinder::search($parserConfig['search']);
		});

		$viewConfig['parsers']['php'] = new \projectorangebox\view\parser\Php($parserConfig);

		/* Markdown Parser */
		/*
		$parserConfig = $container->config->get('parser_markdown');

		$parserConfig['views'] = cache('md_views', function () use ($parserConfig) {
			return \projectorangebox\view\ViewFinder::search($parserConfig['search']);
		});

		$viewConfig['parsers']['md'] = new \projectorangebox\parser\markdown\Markdown($parserConfig);
		*/

		/* CodeIgniter Parser */
		/*
		$parserConfig = $container->config->get('parser_ci');

		$parserConfig['views'] = cache('ci_views', function () use ($parserConfig) {
			return \projectorangebox\view\ViewFinder::search($parserConfig['search']);
		});

		$viewConfig['parsers']['ci'] = new \projectorangebox\parser\ci\CiPlus($parserConfig);
		*/

		/* Handlebars Parser */
		/*
		$parserConfig = $container->config->get('parser_handlebars');

		$parserConfig['templates'] = cache('hbs_views', function () use ($parserConfig) {
			return \projectorangebox\view\ViewFinder::search($parserConfig['search']);
		});

		$parserConfig['helper files'] = cache('hbs_plugins', function () use ($parserConfig) {
			return \projectorangebox\view\ViewFinder::search($parserConfig['helper search']);
		});

		$parserConfig['helpers'] =  (new \projectorangebox\parser\handlebars\HandlebarsPluginCacher($parserConfig))->get();

		$viewConfig['parsers']['hbs'] = new \projectorangebox\parser\handlebars\Handlebars($parserConfig);
		*/

		return new \projectorangebox\view\View($viewConfig);
	}],
	'simpleq' => [function ($container) {
		$dbConfig = $container->config->get('connections', []);

		$connection = $dbConfig['default database'];
		$connection['database_type'] = $connection['type'];
		$connection['database_name'] = $connection['name'];

		$config = $container->config->get('simpleq', []);

		$config['db'] = new \Medoo\Medoo($connection);

		return new \projectorangebox\simpleq\SimpleQ($config);
	}],
	'cookie' => [function ($container) {
		$config = $container->config->get('cookie', []);
		return new \projectorangebox\cookie\Cookie($config);
	}],
	'rememberme' => [function ($container) {
		$config = $container->config->get('rememberme', []);

		$storageConfig['key'] = '73a90acaae2b1ccc0e969709665bc62f';

		$storageConfig['db'] = $container->pdoDefault;
		$config['storage'] = new \projectorangebox\rememberme\RemembermeDatabaseStorage($storageConfig);

		//$storageConfig['folder'] = '/var/remember';
		//$config['storage'] = new \projectorangebox\rememberme\RemembermeFileStorage($storageConfig);

		$config['cookieService'] = $container->cookie;

		return new \projectorangebox\rememberme\Rememberme($config);
	}],
];
