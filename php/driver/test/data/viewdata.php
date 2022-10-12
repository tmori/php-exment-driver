
<?php
require 'vendor/autoload.php';

use Pimple\Container;
use ExmentApi\Driver\Driver;

if( $argc != 3 ){
    echo "Usage: " . $argv[0] . " <table_name> <table_view_id>\n";
    exit(1);
}
$table_name = $argv[1];
$table_view_id = $argv[2];

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
        'scope' => 'value_read', 'value_write'
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
$res = $driver->getDataModel()->get_viewdata(
            $view_id=$table_view_id, 
            $table=$table_name, 
            $page=NULL, 
            $count=NULL, 
            $valuetype=NULL);
echo $res->getBody() . "\n";

?>