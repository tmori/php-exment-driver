
<?php
require 'vendor/autoload.php';

use Pimple\Container;
use ExmentApi\Driver\Driver;

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
            $view_id=38, 
            $table='test_table', 
            $page=NULL, 
            $count=NULL, 
            $valuetype=NULL);
echo $res->getBody() . "\n";

?>