<?php

return [
	// api version
    'api_version' => env('TRAVIS_API_VERSION', "3"),

    // token to access the api
    'api_token' => env('TRAVIS_API_TOKEN', ""),

    //privacy level to determine the URI to hit
    'privacy' => env('TRAVIS_PRIVACY_LEVEL', "public"),

    //custom uri for enterprise use
    'enterprise_uri' => env('TRAVIS_ENTERPRISE_URI', false),
];
