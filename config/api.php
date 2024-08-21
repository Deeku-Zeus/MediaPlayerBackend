<?php

return [
    'maxTryCounts' => env('API_MAX_TRY_COUNTS', 3),
    'apiWaitSeconds' => env('API_WAIT_SECONDS', 3000),
    'sslVerify' => env('API_SSL_VERIFY', true),
];
