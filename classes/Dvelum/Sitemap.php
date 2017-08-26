<?php
namespace Dvelum;

use Dvelum\App\Router\RouterInterface;
use Dvelum\Request;
use Dvelum\Sitemap\AbstractAdapter;

class Sitemap
{
    protected $adapters = [];
    protected $url = '/sitemap.xml';
    protected $host = '127.0.0.1';
    protected $scheme = 'http://';
    /**
     * @var RouterInterface
     */
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $request = Request::factory();
        $this->host = $request->server('HTTP_HOST', 'string', '');
        $this->router = $router;
        if($request->isHttps()){
            $this->scheme = 'https://';
        }
    }

    /**
     * Set sitemap url
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Add sitemap generator
     * @param $code
     * @param AbstractAdapter $adapter
     */
    public function addAdapter($code, AbstractAdapter $adapter)
    {
        $adapter->setRouter($this->router);
        $adapter->setScheme($this->scheme);
        $adapter->setHost($this->host);
        $this->adapters[$code] = $adapter;
    }

    /**
     * Get Sitemap Index XML
     */
    public function getIndexXml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'
             . '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach($this->adapters as $code=>$adapter)
        {
            $xml.= '<sitemap>'
                    . '<loc>'.$this->scheme.$this->host . $this->url . '/' . $code . '</loc>'
                    . '<lastmod>'.date('Y-m-d').'</lastmod>'
                 . '</sitemap>';
        }

        $xml.= '</sitemapindex>';
        return $xml;
    }

    /**
     * Get sitemap XML
     * @param $code - adapter code
     * @return string
     */
    public function getMapXml($code)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        if(isset($this->adapters[$code])){
            $xml.= $this->adapters[$code]->getItemsXML();
        }
        $xml.= '</urlset>';
        return $xml;
    }
}