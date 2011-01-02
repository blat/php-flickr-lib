<?php

class Flickr {

    private $_config = array();
    private $_namespace = null;
    private $_options = array(
        'proxy' => array(
            'user_agent' => 'PHP Flickr',
            'timeout'    => 10
        ),
        'cache' => array(
            'enabled'   => false,
            'path'       => '/tmp',
            'expiration' => 300,
            'version'    => 1
        )
    );

    const URL = 'http://api.flickr.com/services/rest/';

    public function __construct(array $options = array()) {
        foreach ($this->_options as $key => $values) {
            if (!isset($options[$key])) continue;
            $this->_options[$key] = array_merge($values, $options[$key]);
        }
    }

    public function __set($key, $value) {
        $this->_config[$key] = $value;
    }

    public function __get($key) {
        // Set namespace
        $this->_namespace = $key;
        return $this;
    }

    public function __call($name, $args) {

        if (empty($this->_config['api_key'])) {
            throw new Exception('Api key is undefined');
        }

        if (empty($this->_namespace)) {
            throw new Exception('Namespace is undefined');
        }

        // Build parameter list
        $params = !empty($args) ? current($args) : array();
        $params = array_merge($params, $this->_config);
        $params['method'] = 'flickr.' . $this->_namespace . '.' . $name;
        $params['format'] = 'php_serial';

        // Reset namespace
        $this->_namespace = null;

        // Build URL
        $url = self::URL;
        if (!empty($params)) {
           $url .= '?' . http_build_query($params);
        }

        if ($this->_options['cache']['enabled']) {

            if (!is_writable($this->_options['cache']['path'])) {
                throw new Exception('Cache directory is not writable');
            }

            // Get from cache
            $file = $this->_options['cache']['path'] . '/' . md5($url) . '.' . $this->_options['cache']['version'];
            if (file_exists($file) && filemtime($file) > time() - $this->_options['cache']['expiration']) {
                $data = file_get_contents($file);
            }
        }

        // Not found in cache?
        if (empty($data)) {

            // Fetch Flickr's API
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            if (defined('PROXY_USER_AGENT')) {
                curl_setopt($curl, CURLOPT_USERAGENT, $this->_options['proxy']['user_agent']);
            }
            if (defined('PROXY_TIMEOUT')) {
                curl_setopt($curl, CURLOPT_TIMEOUT, $this->_options['proxy']['timeout']);
            }
            $data = curl_exec($curl);
            curl_close($curl);

            if ($this->_options['cache']['enabled']) {
                // Save in cache
                file_put_contents($file, $data);
            }
        }

        // Unserialize data
        $data = unserialize($data);

        // Check response
        if ($data['stat'] == 'fail') {
            throw new Exception($data['message'], $data['code']);
        }
        unset($data['stat'], $data['message'], $data['code']);

        // Convert data as StdClass
        $data = json_decode(json_encode($data));
        return $data;
    }

}
