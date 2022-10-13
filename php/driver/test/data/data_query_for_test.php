
<?php
require 'vendor/autoload.php';

use Pimple\Container;
use ExmentApi\Driver\Driver;

$table_name = 'test_data';

if( $argc != 3 ){
    echo "Usage: " . $argv[0] . " <id1> <id2>\n";
    exit(1);
}
$id1 = $argv[1];
$id2 = $argv[2];

$value1='usr=' . str_pad($id1, 3, 0, STR_PAD_LEFT) . ':'; 
$value2='rid=' . str_pad($id2, 3, 0, STR_PAD_LEFT) . ':'; 
$keyword = $value1 . $value2;

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
if ($code != "200")
{
    exit(1);
}
$res = $driver->getDataModel()->data_query(
            $table=$table_name, 
            $query=$keyword,
            $page=NULL, 
            $count=NULL, 
            $label=NULL, 
            $valuetype=NULL, 
            $children=NULL);

if ($res->getStatusCode() == "200")
{
    //echo $res->getBody() . "\n";
    echo "OK: ResCode=" . $res->getStatusCode() . " id1=" . $id1 . " id2=" . $id2 . "\n";
}
else{
    $phrase = $result->getReasonPhrase();
    echo "NG: ResCode=" . $res->getStatusCode() . " id1=" . $id1 . " id2=" . $id2 . " phrase=" . $phrase . "\n";
}

?>