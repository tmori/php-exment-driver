<?php
/**
 * This Driver is based entirely on official documentation of the Exment Web
 * Services API and you can extend it by following the directives of the documentation.
 *
 * @author Takashi Mori <kanetugu2015@gmail.com>
 * @link https://exment.net/reference/ja/webapi.html
 */

namespace ExmentApi\Driver;

use ExmentApi\Driver\Models\SystemModel;
use ExmentApi\Driver\Models\TableModel;
use ExmentApi\Driver\Models\DataModel;

use GuzzleHttp\Psr7\Response;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Driver
 *
 * @package ExmentApi\Driver
 */
class Driver
{
    /**
     * Default options of the Driver
     *
     * @var array
     */
    private $defaultOptions = [
        'scheme' => 'https',
        'basePath' => '',
        'url' => 'localhost',
        'login_id' => null,
        'password' => null,
        'token' => null,
    ];

    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $models = [];

    /**
     * Driver constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $driverOptions = $this->defaultOptions;

        if (isset($container['driver'])) {
            $driverOptions = array_merge($driverOptions, $container['driver']);
        }

        $container['driver'] = $driverOptions;
        $container['client'] = new Client($container);

        $this->container = $container;
    }

    /**
     * @return ResponseInterface
     */
    public function api_key_authenticate()
    {
        if (isset($this->container['auth'])) {
            $response = $this->container['client']->post('/oauth/token', $this->container['auth']);
            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $jsonstr =  json_decode($body, true);
                $token = $jsonstr['access_token'];
                #echo "token=" . $token . "\n";
                $this->container['client']->setToken($token);
            }
        } else {

            $response = new Response(401, [], json_encode([
                "id" => "missing.credentials.",
                "message" => "You must provide a login_id and password or a valid token.",
                "detailed_error" => "",
                "request_id" => "",
                "status_code" => 401,
            ]));

        }

        return $response;
    }

    /**
     * @param $className
     * @return mixed
     */
    private function getModel($className)
    {
        if (!isset($this->models[$className])) {
            $this->models[$className] = new $className($this->container['client']);
        }

        return $this->models[$className];
    }

    /**
     * @return SystemModel
     */
    public function getSystemModel()
    {
        return $this->getModel(SystemModel::class);
    }
    /**
     * @return TableModel
     */
    public function getTableModel()
    {
        return $this->getModel(TableModel::class);
    }
    /**
     * @return DataModel
     */
    public function getDataModel()
    {
        return $this->getModel(DataModel::class);
    }

}
?>