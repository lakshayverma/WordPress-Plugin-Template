<?php


trait WordPress_Plugin_Template_CORS {

    public static function get_available_origins()
    {
        return [
            'http://localhost:3000',
        ];
    }

    public function add_allowed_origins($origins)
    {
        $available = static::get_available_origins();
        array_merge($origins, $available);

        return $origins;
    }

    public function send_origin_headers()
    {
        $origin = get_http_origin();
        @header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE' );

        if (is_allowed_http_origin($origin) || in_array(get_http_origin(), $this->add_allowed_origins([]))) {
            @header('Access-Control-Allow-Origin: ' . $origin);
            @header('Access-Control-Allow-Credentials: true');

            if ('OPTIONS' === $_SERVER['REQUEST_METHOD']) {
                exit;
            }
            return $origin;
        }
        if ('OPTIONS' === $_SERVER['REQUEST_METHOD']) {
            status_header(403);
            exit;
        }
        return false;
    }
}
