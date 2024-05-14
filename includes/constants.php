<?php
$data = parse_ini_file(".env");

define("SITE_URL", $data["ENV_SITE_URL"]);
define("DB_HOST", $data["ENV_DB_HOST"]);
define("DB_NAME", $data["ENV_DB_NAME"]);
define("DB_ADMIN_LOGIN", $data["ENV_DB_ADMIN"]);
define("DB_ADMIN_PASSWORD", $data["ENV_DB_PASSWORD"]);
define("DB_PORT", $data["ENV_DB_PORT"]);

define("PHONENUM", "phonenum");

define("MAIL_HOST", $data["ENV_MAIL_HOST"]);
define("MAIL_USERNAME", $data["ENV_MAIL_USERNAME"]);
define("MAIL_PASSWORD", $data["ENV_MAIL_PASSWORD"]);
define("MAIL_PORT", $data["ENV_MAIL_PORT"]);
define("MAIL_FROM_ADDRESS", $data["ENV_MAIL_FROM_ADDRESS"]);


?>
