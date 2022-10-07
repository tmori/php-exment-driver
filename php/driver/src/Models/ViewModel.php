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
class ViewModel extends AbstractModel
{
    /**
     * @var string
     */
    public static $endpoint = '/api';

    public function view_info($id)
    {
        return $this->client->get(self::$endpoint . '/view/' . strval($id), []);
    }

    public function view_list($table, $view_type, $view_kind_type, $view_view_name)
    {
        $query_params = [
        ];
        if (isset($view_type)) {
            $query_params = array_merge($query_params, ['view_type' => strval($view_type) ]);
        }
        if (isset($view_kind_type)) {
            $query_params = array_merge($query_params, ['view_kind_type' => strval($view_kind_type) ]);
        }
        if (isset($view_view_name)) {
            $query_params = array_merge($query_params, ['view_view_name' => strval($view_view_name) ]);
        }

        return $this->client->get(self::$endpoint . '/table/' . strval($table) . '/views', $query_params);
    }

}
?>