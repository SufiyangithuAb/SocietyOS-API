<?php

require_once "../middleware/auth.php";

response(
    true,
    "Authorized",
    [
        "user" => $GLOBALS['auth_user']
    ]
);
