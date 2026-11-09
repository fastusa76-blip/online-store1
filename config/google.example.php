<?php
// Copy to config/google.local.php and add OAuth credentials from Google Cloud Console.
// Authorized redirect URI: https://YOUR-DOMAIN/google/callback
return [
    'client_id' => 'YOUR_GOOGLE_OAUTH_CLIENT_ID',
    'client_secret' => 'YOUR_GOOGLE_OAUTH_CLIENT_SECRET',
    'redirect_uri' => 'https://YOUR-DOMAIN/google/callback',
];
