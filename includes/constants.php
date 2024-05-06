<?php

$env = parse_ini_file('.env');



define("DB_HOST", $env["ENV_DB_HOST"]);
define("DATABASE", $env["ENV_DATABASE"]);
define("DB_ADMIN", $env["ENV_DB_ADMIN"]);
define("DB_PORT", $env["ENV_DB_PORT"]);
define("DB_PASSWORD", $env["ENV_DB_PASSWORD"]);

//define("DB_HOST", getenv(ENV_DB_HOST));
//define("DATABASE", getenv(ENV_DATABASE));
//define("DB_ADMIN", getenv(ENV_DB_ADMIN));
//define("DB_PORT", getenv(ENV_DATABASE));
//define("DB_PASSWORD", getenv(ENV_DATABASE));
//SetEnv ENV_DB_HOST "localhost"
//SetEnv ENV_DATABASE "budek_db"
//SetEnv ENV_DB_ADMIN "budek"
//SetEnv ENV_DB_PORT "5432"
//SetEnv ENV_DB_PASSWORD "100665867"

const Administrator = "a";
const RECORDS_PER_PAGE = 10;
const UPLOADS_DIR = "./uploads/";

const TYPE_PNG = ".png";
const TYPE_JPEG = ".jpeg";
const MAX_FILE_SIZE = 2000000;

const MIN_PASSWORD_LENGTH = 6;
const MAX_PASSWORD_LENGTH = 100;
const MIN_FIRST_NAME_LENGTH = 2;
const MAX_FIRST_NAME_LENGTH = 100;
const MIN_LAST_NAME_LENGTH = 2;
const MAX_LAST_NAME_LENGTH = 100;
const MIN_EMAIL_LENGTH = 5;
const MAX_EMAIL_LENGTH = 100;
const MIN_PHONE_LENGTH = 1000000000;
const MAX_PHONE_LENGTH = 9999999999;
?>