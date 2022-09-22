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
class TableModel extends AbstractModel
{
    /**
     * @var string
     */
    public static $endpoint = '/api';

    /**
     * @return ResponseInterface
     */
    public function table($page=1, $count=20, $id=NULL, $expands=NULL)
    {
        $query_params = [
            'page' => $page,
            'count' => $count
        ];
        if (isset($id)) {
            $query_params = array_merge($query_params, ['id' => strval($id) ]);
        }
        if (isset($expands)) {
            $query_params = array_merge($query_params, ['expands' => strval($expands) ]);
        }
        return $this->client->get(self::$endpoint . '/table', $query_params);
    }
    public function table_info($table_key)
    {
        return $this->client->get(self::$endpoint . '/table/' . strval($table_key), []);
    }
    public function table_columns($table_key)
    {
        return $this->client->get(self::$endpoint . '/table/' . strval($table_key) . '/columns', []);
    }
    public function table_column_id_info($column_id)
    {
        return $this->client->get(self::$endpoint . '/column/' . strval($column_id), []);
    }
    public function table_column_info($table_key, $column_key)
    {
        return $this->client->get(self::$endpoint . '/table/' . strval($table_key) . '/column/' . strval($column_key), []);
    }

}
?>