<?php
$data = parse_ini_file(".env");

define("DB_HOST", $data["ENV_DB_HOST"]);
define("DB_NAME", $data["ENV_DB_NAME"]);
define("DB_ADMIN_LOGIN", $data["ENV_DB_ADMIN"]);
define("DB_ADMIN_PASSWORD", $data["ENV_DB_PASSWORD"]);
define("DB_PORT", $data["ENV_DB_PORT"]);

define("PHONENUM", "phonenum");
?>
