<?php

// 全局变量

return [
    'cache_expire'         => 1440,
    'gitee_hook_password'  => env('GITEE_HOOK_PASSWORD'),
    'gogs_hook_password'   => env('GOGS_HOOK_PASSWORD'),
    'github_hook_password' => env('GITHUB_HOOK_PASSWORD'),
    'bd_push_token'        => env('BD_PUSH_TOKEN'),
    'bd_tongji_id'         => env('BD_TONGJI_ID'),
    'google_analytics_id'  => env('GOOGLE_ANALYTICS_ID'),
    'api_token'            => env('API_TOKEN'),
    'image_water_mark'     => public_path('img/water_mark.png'),
];
