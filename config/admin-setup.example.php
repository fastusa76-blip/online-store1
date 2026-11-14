<?php
// Copy this file to admin-setup.local.php in the same config folder.
// Replace the placeholder with a new, private random secret (at least 32 characters).
// Enter that same secret once at /admin/setup. Never commit the .local.php copy.
return hash('sha256', 'REPLACE-WITH-A-NEW-RANDOM-SECRET-AT-LEAST-32-CHARS');
