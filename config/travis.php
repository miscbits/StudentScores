<?php

return [
    'api_version' => env('TRAVIS_API_VERSION', "3"),
    'api_token' => env('TRAVIS_API_TOKEN', ""),
    'privacy' => env('TRAVIS_PRIVACY_LEVEL', "public")
];
