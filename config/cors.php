<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

<<<<<<< HEAD
    'allowed_origins' => ['http://localhost:3000' , 'http://localhost:3002'],
=======
'allowed_origins' => [
    'http://localhost:3000',
    'http://localhost:3002',
],
>>>>>>> 25ce2ef525261f3944db630334ebd39adcc18731

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
<<<<<<< HEAD

-
=======
>>>>>>> 25ce2ef525261f3944db630334ebd39adcc18731
