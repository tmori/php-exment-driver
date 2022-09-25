
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
        'scope' => 'value_write'
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
$create_data = [
    "col1" => "col1_new_data1",
    "col2" => "col2_new_data1",
    "col3" => "col3_new_data1",
    "col4" => "col4_new_data1",
];
$res = $driver->getDataModel()->data_create(
            $table='test_table', 
            $value=$create_data,
            $findKeys=NULL, 
            $data=NULL, 
            $parent_type=NULL, 
            $parent_id=NULL, 
            $label=NULL);
echo $res->getBody() . "\n";

?>