<?php
/**
 * This Driver is based entirely on official documentation of the Exment Web
 * Services API and you can extend it by following the directives of the documentation.
 *
 * @author Takashi Mori <kanetugu2015@gmail.com>
 * @link https://exment.net/reference/ja/webapi.html
 */

namespace ExmentApi\Driver\Models;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Class SystemEntity
 *
 * @package ExmentApi\Driver\Models
 */
class SystemModel extends AbstractModel
{
    /**
     * @var string
     */
    public static $endpoint = '/api';

    /**
     * @return ResponseInterface
     */
    public function version()
    {
        return $this->client->get(self::$endpoint . '/version', []);
    }
    /**
     * @return ResponseInterface
     */
    public function me()
    {
        return $this->client->get(self::$endpoint . '/me', []);
    }
    /**
     * @return ResponseInterface
     */
    public function avatar()
    {
        return $this->client->get(self::$endpoint . '/avatar', []);
    }

}
?>