<?php
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('templates.path' => $_SERVER['DOCUMENT_ROOT'] . "/views"));
//$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () use ($app) {
	$app->renderIndex();
	//$req = $app->request();
	//$title = $req->params('title');
});

$app->get('/dashboard', function () use ($app) {
	$app->renderIndex();
});

$app->get('/login', function () use ($app) {
	$app->renderIndex();
});

$app->get('/logout', function () use ($app) {
	$app->renderIndex();
});

$app->get('/profile', function () use ($app) {
	$app->renderIndex();
});

$app->get('/user-management', function () use ($app) {
	$app->renderIndex();
});

$app->get('/register', function () use ($app) {
	$app->renderIndex();
});

$app->get('/forgot', function () use ($app) {
	$app->renderIndex();
});

$app->get('/lock-screen', function () use ($app) {
	$app->renderIndex();
});

$app->group('/categories', function () use ($app) {
	$app->get('/', function () use ($app) {
		$app->renderIndex();
	});
	$app->get('/:id', function ($id) use ($app) {
		$app->renderIndex();
	});
});

$app->group('/issues', function () use ($app) {
	$app->get('/', function () use ($app) {
		$app->renderIndex();
	});
	$app->get('/:id', function ($id) use ($app) {
		$app->renderIndex();
	});
});

$app->group('/shops', function () use ($app) {
	$app->get('/', function () use ($app) {
		$app->renderIndex();
	});
	$app->get('/:id', function ($id) use ($app) {
		$app->renderIndex();
	});
});

$app->group('/deals', function () use ($app) {
	$app->get('/', function () use ($app) {
		$app->renderIndex();
	});
	$app->get('/:id', function ($id) use ($app) {
		$app->renderIndex();
	});
});

$app->group('/coupons', function () use ($app) {
	$app->get('/', function () use ($app) {
		$app->renderIndex();
	});
	$app->get('/:id', function ($id) use ($app) {
		$app->renderIndex();
	});
});

$app->post('/saveImage', function () use ($app) {
	$body = json_decode($app->request()->getBody());
	$params = (array) $body;
	$name = $params['id'] . '_' . $params['index'] . '.jpg';
	$url = 'temp/' . $name;

	// remove the base64 part
	$base64 = preg_replace('#^data:image/[^;]+;base64,#', '', $params['image']);
	$base64 = base64_decode($base64);

	$source = imagecreatefromstring($base64); // create
	imagejpeg($source, $url, 100); // save image

	// return URL
	$validation = array (
	'url'     => $url,
	'thumb'   => $url . '?' . sha1(uniqid(mt_rand(), true)),
	'name'    => $name
	);
	echo json_encode($validation);
});

$app->group('/api', function () use ($app) {
    $app->post('/itemmaster', function () use ($app) {
        $body = json_decode($app->request()->getBody());
        $params = (array) $body;
        // remove spaces in query
        $params['query'] = str_replace(' ', '+', $params['query']);
        $query = 'https://api.itemmaster.com/v2/item?idx=0&limit=50&q=' . $params['query']. '&ef=jpg&epl=200';

        // Get cURL resource
        $curl = curl_init($query);
        // Set some options - we are passing in a useragent too here
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'username: ' . $params['username'],
            'password: ' . $params['password']
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, 1);
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => true
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        // Convert XML it JSON Object
        $xml = simplexml_load_string($resp);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        echo json_encode($array);
    });
});


// Front-End Pages
$app->get('/pricing', function () use ($app) {
	$app->renderIndex();
});

$app->get('/services', function () use ($app) {
	$app->renderIndex();
});

$app->get('/features', function () use ($app) {
	$app->renderIndex();
});

$app->get('/about', function () use ($app) {
	$app->renderIndex();
});

$app->get('/contact', function () use ($app) {
	$app->renderIndex();
});

$app->get('/home', function () use ($app) {
	$app->renderIndex();
});

$app->run();