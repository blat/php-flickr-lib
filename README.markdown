PHP Flickr
===============
This library allows you to query [Flickr's API](http://www.flickr.com/services/api/).

usage
------------------

1.  get an [API Key](http://www.flickr.com/services/apps/create/apply/)
1.  in your config file
        api_key = "YOUR_API_KEY"

        [proxy]
        user_agent = "Mozilla/5.0 (compatible)"
        timeout = 5

        [cache]
        enabled = true
        path = CACHE_DIR
        expiration = 1200
        version = 1
2.  in your php script
        define('APP_ROOT', dirname(__FILE__));
        define('CACHE_DIR', APP_ROOT . '/tmp');
        require_once APP_ROOT . '/flickr.php';

        $config = parse_ini_file(APP_ROOT . '/config.ini', true);

        $flickr = new Flickr($config);
        $flickr->api_key = $config['api_key'];

        $flickr->photos->getInfo(array('photo_id' => '4996628146'));
        $flickr->photosets->getList(array('user_id' => '44244432@N03'));

This library works with all [methods](http://www.flickr.com/services/api/) except those which require authentication.

mit licence
------------------
Copyright (c) 2010 Mickael BLATIERE

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

