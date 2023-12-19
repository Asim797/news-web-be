<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Pagination
    |--------------------------------------------------------------------------
    |
    | This value is used to set the default pagination count for the entire
    | application. You can modify this value to change the default number
    | of items displayed per page when paginating data.
    |
    */

    'default_pagination'  =>  25,

    /*
    |--------------------------------------------------------------------------
    | Default API Token Secret
    |--------------------------------------------------------------------------
    |
    | This value is used to set the default api token secret for the entire
    | application.
    |
    */
    'api_token_secret'    =>  env('API_TOKEN_SECRET', 'laravel-test-token'),

    /*
    |--------------------------------------------------------------------------
    | API Keys for News Api Org
    |--------------------------------------------------------------------------
    |
    | These value is used to set the base url of the third party library and api key.
    |
    */
    'news_api_org_url'    =>  env('NEWS_API_ORG_URL', 'https://newsapi.org'),
    'news_api_org_key'    =>  env('NEWS_API_ORG_KEY', '5e90100d11154cf7b272006158151d38'),

    /*
    |--------------------------------------------------------------------------
    | API Keys for Guardian
    |--------------------------------------------------------------------------
    |
    | These value is used to set the base url of the third party library and api key.
    |
    */
    'guardian_api_url'    =>  env('GUARDIAN_API_URL', 'https://content.guardianapis.com'),
    'guardian_api_key'    =>  env('GUARDIAN_API_KEY', 'c260f1bd-cbbc-439d-9f97-b6dee54f9407'),

    /*
    |--------------------------------------------------------------------------
    | API Keys for New York Times
    |--------------------------------------------------------------------------
    |
    | These value is used to set the base url of the third party library and api key.
    |
    */
    'new_york_times_url'    =>  env('NEW_YORK_TIMES_URL', 'https://api.nytimes.com'),
    'new_york_times_api_key'    =>  env('NEW_YORK_TIMES_API_KEY', 'aAiPcoiOR8hrvYlGIIIsZchcLa4KadvM'),
    'new_york_times_image_url'    =>  env('NEW_YORK_TIMES_IMAGE_URL', 'https://www.nytimes.com/'),

];
