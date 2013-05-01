PHP Flickr
===============

This library allows you to query [Flickr's API](http://www.flickr.com/services/api/).

Usage
------------------

1.  Get a [Flickr API Key](http://www.flickr.com/services/apps/create/apply/)

2.  Edit `config.ini`:

        api_key = "YOUR_API_KEY"
        
3.  Then, in your PHP code:

        define('APP_ROOT', dirname(__FILE__));
        define('CACHE_DIR', APP_ROOT . '/tmp');
        require_once APP_ROOT . '/flickr.php';

        $config = parse_ini_file(APP_ROOT . '/config.ini', true);

        $flickr = new Flickr($config);
        $flickr->api_key = $config['api_key'];

        $flickr->photos->getInfo(array('photo_id' => '4996628146'));
        $flickr->photosets->getList(array('user_id' => '44244432@N03'));

 This library works with all [methods](http://www.flickr.com/services/api/) except those which require authentication.
