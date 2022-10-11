
<?php
require 'vendor/autoload.php';

use Pimple\Container;
use ExmentApi\Driver\Driver;

//base parameters
$table_name = 'test_data';
$col_num = 18;
$col_str_max = 256;
$date = '2022-10-11';

if( $argc != 3 ){
    echo "Usage: " . $argv[0] . " <id1> <id2>\n";
    exit(1);
}
$id1 = $argv[1];
$id2 = $argv[2];

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
    'user' => $id1,
    "date" => $date
];
for ( $i = 1; $i <= $col_num; $i++ )
{
    $col_name = 'col' . strval($i);
    $value1 = 'col=' . str_pad(strval($i), 3, 0, STR_PAD_LEFT) . ':'; 
    $value2 = 'usr=' . str_pad($id1, 3, 0, STR_PAD_LEFT) . ':'; 
    $value3 = 'rid=' . str_pad($id2, 3, 0, STR_PAD_LEFT) . ':'; 
    $value4 = str_pad(strval($i), $col_str_max - strlen($value1 . $value2 . $value3), 'X', STR_PAD_LEFT); 
    $value = $value1 . $value2 . $value3 . $value4;
    $create_data[$col_name] = $value;
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