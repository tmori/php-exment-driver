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
class DataModel extends AbstractModel
{
    /**
     * @var string
     */
    public static $endpoint = '/api';

    /**
     * @param table string
     * @param page integer
     * @param count integer
     * @param orderby string
     * @param id string
     * @param label integer
     * @param valuetype string
     * @param children integer
     * 
     * @return ResponseInterface
     */
    public function data($table, $page, $count, $orderby, $id, $label, $valuetype, $children)
    {
        $query_params = [
            'page' => $page,
            'count' => $count
        ];
        if (isset($orderby)) {
            $query_params = array_merge($query_params, ['orderby' => strval($orderby) ]);
        }
        if (isset($id)) {
            $query_params = array_merge($query_params, ['id' => strval($id) ]);
        }
        if (isset($label)) {
            $query_params = array_merge($query_params, ['label' => $label ]);
        }
        if (isset($valuetype)) {
            $query_params = array_merge($query_params, ['valuetype' => strval($valuetype) ]);
        }
        if (isset($children)) {
            $query_params = array_merge($query_params, ['children' => $children ]);
        }
        return $this->client->get(self::$endpoint . '/data/' . strval($table), $query_params);
    }

    public function data_query($table, $query, $page, $count, $label, $valuetype, $children)
    {
        $query_params = [
            'q' => $query,
            'page' => $page,
            'count' => $count
        ];
        if (isset($label)) {
            $query_params = array_merge($query_params, ['label' => $label ]);
        }
        if (isset($valuetype)) {
            $query_params = array_merge($query_params, ['valuetype' => strval($valuetype) ]);
        }
        if (isset($children)) {
            $query_params = array_merge($query_params, ['children' => $children ]);
        }
        return $this->client->get(self::$endpoint . '/data/' . strval($table) . '/query', $query_params);
    }

    public function data_query_column($table, $query, $page, $count, $label, $valuetype, $or, $orderby, $children)
    {
        $query_params = [
            'q' => $query,
            'page' => $page,
            'count' => $count
        ];
        if (isset($label)) {
            $query_params = array_merge($query_params, ['label' => $label ]);
        }
        if (isset($valuetype)) {
            $query_params = array_merge($query_params, ['valuetype' => strval($valuetype) ]);
        }
        if (isset($or)) {
            $query_params = array_merge($query_params, ['or' => strval($or) ]);
        }
        if (isset($orderby)) {
            $query_params = array_merge($query_params, ['orderby' => strval($orderby) ]);
        }
        if (isset($children)) {
            $query_params = array_merge($query_params, ['children' => $children ]);
        }
        return $this->client->get(self::$endpoint . '/data/' . strval($table) . '/query-column', $query_params);
    }

    public function data_id($table, $id, $label, $valuetype, $children)
    {
        $query_params = [
        ];
        if (isset($label)) {
            $query_params = array_merge($query_params, ['label' => $label ]);
        }
        if (isset($valuetype)) {
            $query_params = array_merge($query_params, ['valuetype' => strval($valuetype) ]);
        }
        if (isset($children)) {
            $query_params = array_merge($query_params, ['children' => $children ]);
        }
        return $this->client->get(self::$endpoint . '/data/' . strval($table) . '/' . strval($id), $query_params);
    }

    public function data_create($table, $value, $findKeys, $data, $parent_type, $parent_id, $label)
    {
        $request_body = [
        ];
        if (isset($value)) {
            $request_body = array_merge($request_body, ['value' => $value ]);
        }
        if (isset($findKeys)) {
            $request_body = array_merge($request_body, ['findKeys' => $findKeys ]);
        }
        if (isset($data)) {
            $request_body = array_merge($request_body, ['data' => $data ]);
        }
        if (isset($parent_type)) {
            $request_body = array_merge($request_body, ['parent_type' => $parent_type ]);
        }
        if (isset($parent_id)) {
            $request_body = array_merge($request_body, ['parent_id' => $parent_id ]);
        }
        if (isset($label)) {
            $request_body = array_merge($request_body, ['label' => $label ]);
        }
        return $this->client->post(self::$endpoint . '/data/' . strval($table), $request_body);
    }

    public function data_update($table, $id, $value, $findKeys, $parent_type, $parent_id, $label)
    {
        $request_body = [
        ];
        if (isset($value)) {
            $request_body = array_merge($request_body, ['value' => $value ]);
        }
        if (isset($findKeys)) {
            $request_body = array_merge($request_body, ['findKeys' => $findKeys ]);
        }
        if (isset($parent_type)) {
            $request_body = array_merge($request_body, ['parent_type' => $parent_type ]);
        }
        if (isset($parent_id)) {
            $request_body = array_merge($request_body, ['parent_id' => $parent_id ]);
        }
        if (isset($label)) {
            $request_body = array_merge($request_body, ['label' => $label ]);
        }
        return $this->client->put(self::$endpoint . '/data/' . strval($table) . '/' . strval($id), $request_body);
    }

    public function data_delete($table, $id, $force)
    {
        $query_params = [
        ];
        if (isset($force)) {
            $query_params = array_merge($query_params, ['force' => $force ]);
        }
        return $this->client->delete(self::$endpoint . '/data/' . strval($table) . '/' . strval($id), $query_params);
    }

}
?>