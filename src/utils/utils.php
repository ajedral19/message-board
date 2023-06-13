<?php
class ResponseHanler
{
    public static function sendMsg(string $msg, ?string $status = null)
    {
        $response = [
            "status" => $status ? $status : 'ok',
            "message" => $msg,
            "date" => date("Y-m-d h:m:s A")
        ];

        return json_encode($response);
    }

    public static function sendErr(?string $msg)
    {
        $message = $msg ? $msg : "unknown failure of process";

        return ResponseHanler::sendMsg($message, 'fail');
    }

    public static function send($data)
    {
        if (!$data || !count($data))
            return ResponseHanler::sendErr('No data has found');

        $response = [
            "status" => "ok",
            "rowCount" => count($data),
            "rows" => $data,
            "date" => date("Y-m-d h:m:s A")
        ];

        return json_encode($response);
    }
}

class Utils extends ResponseHanler
{
    /**
     * @return
     */
    public static function desctructureURI(string $uri)
    {
        if (!$uri) return;

        $uri_extracted = array();

        foreach (explode('/', $uri) as $key => $path) {
            if ($path) {
                if (preg_match('(\?.*)', $path, $mathches)) {
                    echo json_encode($mathches);
                }
                array_push($uri_extracted,  $path);
            }
        }
        return $uri_extracted;
    }

    /**
     * @return
     */
    public static function shortenID($str)
    {
        return explode('-', $str)[0];
    }

    public static function validateField(array $params, object $data)
    {
        $ef = [];

        foreach ($params as $param) {
            if (!isset($data->$param) || !$data->$param) {
                array_push($ef, $param);
            }
        }

        return $ef;
    }

    /**
     * @return
     */
    public static function extracParams(string $query)
    {

        $explodedQuery = explode('&', $query);
        $params = [];

        foreach ($explodedQuery as $key => $value) {
            $param = explode('=', $value);
            array_push($params, [$param[0] => $param[1]]);
        }

        return $params;
    }

    /**
     * @return
     */
    public static function log($msg)
    {
        $log = date('D M j G:i:s') . str_repeat("\x20", 5) . $msg;

        $file = '.log';

        if (!file_exists($file)) {
            return file_put_contents($file, $log);
        }

        $fp = fopen($file, 'a');
        fwrite($fp, $log);
        fclose($fp);
    }

    /**
     * @return
     */
    public static function requestMethod($method)
    {
        $method = strtoupper($method);
        return $method === $_SERVER['REQUEST_METHOD'];
    }

    public static function encode_image($path, $name, $type)
    {
        $bloberize = file_get_contents($path);
        $base64 = $name . "\\" . $type . "\\" . base64_encode($bloberize);
        return $base64;
    }

    public static function decode_image($encoded_image)
    {
        $data = explode('\\', $encoded_image);
        $result = [
            "name" => $data[0],
            "type" => $data[1],
            "base64" => ($data[2])
        ];
        return $result;
    }

    public static function encode_id($id)
    {
        return rtrim(strtr(base64_encode($id), '+/', '-_'), '=');
    }

    public static function decode_id($base64)
    {
        $id = base64_decode(str_pad(strtr($base64, '-_', '+/'), strlen($base64) % 4, '=', STR_PAD_RIGHT));
        return $id;
    }

    public static function get_image_uri($id)
    {
        $slug = self::encode_id($id);
        $domain = explode('/', $_SERVER['REQUEST_URI'])[1];
        $server = $_SERVER['SERVER_NAME'];
        $request_scheme = $_SERVER['REQUEST_SCHEME'];

        $url = $request_scheme . "://" . $server . "/" . $domain . "/?image=" . $slug;

        return $url;
    }
}
