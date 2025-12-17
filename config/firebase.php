<?php

return [
    'project_id' => getenv('FIREBASE_PROJECT_ID'),
    'service_account' => getenv('FIREBASE_SERVICE_ACCOUNT_FILE') ? __DIR__ . '/../' . getenv('FIREBASE_SERVICE_ACCOUNT_FILE') : null,
];
