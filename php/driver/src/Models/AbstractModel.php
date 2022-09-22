<?php
/**
 * This Driver is based entirely on official documentation of the Exment Web
 * Services API and you can extend it by following the directives of the documentation.
 *
 * @author Takashi Mori <kanetugu2015@gmail.com>
 * @link https://exment.net/reference/ja/webapi.html
 */

namespace ExmentApi\Driver\Models;

use ExmentApi\Driver\Client;

/**
 * Class AbstractModel
 *
 * @package ExmentApi\Driver\Models
 */
abstract class AbstractModel
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * AbstractModel constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

}
?>