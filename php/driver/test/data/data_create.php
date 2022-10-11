
<?php
require 'vendor/autoload.php';

use Pimple\Container;
use ExmentApi\Driver\Driver;

if( $argc != 3 ){
    echo "Usage: " . $argv[0] . " <table_name> <json_file>\n";
    exit(1);
}
$table_name = $argv[1];
$json_file = file_get_contents($argv[2]);
$json_data = json_decode($json_file, true);

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

$create_data = [];
foreach( $json_data as $key => $value )
{
    //echo $key . " " . $value . "\n";
    $create_data[$key] = $value;
}

$res = $driver->getDataModel()->data_create(
            $table=$table_name, 
            $value=$create_data,
            $findKeys=NULL, 
            $data=NULL, 
            $parent_type=NULL, 
            $parent_id=NULL, 
            $label=NULL);
if ($res->getStatusCode() == "201")
{
    echo "OK: ResCode=" . $res->getStatusCode() . "\n";
}
else{
    echo "NG: ResCode=" . $res->getStatusCode() . "\n";
}

?>