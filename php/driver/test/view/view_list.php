
<?php
require 'vendor/autoload.php';

use Pimple\Container;
use ExmentApi\Driver\Driver;

if( $argc != 2 ){
    echo "Usage: " . $argv[0] . " <table_name>\n";
    exit(1);
}
$table_name = $argv[1];

$container = new \Pimple\Container([
    'driver' => [
        'scheme' => 'http',
        'url' => getenv('EXMENT_URL') . '/admin',
    ],
    'auth' => [
        'grant_type' => 'api_key',
        'client_id' => getenv('EXMENT_CLIENT_ID'),
        'client_secret' => getenv('EXMENT_CLIENT_SECRET'),
        'api_key' => getenv('EXMENT_APK_KEY'),
        'scope' => 'view_read'
    ],
    'guzzle' => [
        'verify' => false
    ]
]);
$driver = new Driver($container);
$result = $driver->api_key_authenticate();
$code = strval($result->getStatusCode());
$phrase = $result->getReasonPhrase();
echo "code=${code} : ${phrase}\n";
$res = $driver->getViewModel()->view_list(
    $table=$table_name,
    $view_type = NULL,
    $view_kind_type = NULL,
    $view_view_name = NULL
);
echo $res->getBody() . "\n";

?>