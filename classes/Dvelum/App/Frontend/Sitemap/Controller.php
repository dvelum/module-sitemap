<?php
namespace Dvelum\App\Frontend\Sitemap;

use Dvelum\App\Frontend;
use Dvelum\Sitemap;
use Dvelum\Config;

class Controller extends Frontend\Controller
{
    public function indexAction()
    {
        $curCode = $this->request->getPart(1);
        $sitemap = new Sitemap($this->router);
        $sitemap->setUrl($this->request->url([$this->router->findUrl('dvelum_sitemap')],false));

        $siteMapAdapters = Config::storage()->get('sitemap.php');

        if(!empty($siteMapAdapters))
        {
            $siteMapAdapters = $siteMapAdapters->__toArray();
            foreach($siteMapAdapters as $code => $class){
                $sitemap->addAdapter($code, new $class);
            }
        }else{
            $siteMapAdapters = [];
        }

        if(!empty($curCode) && isset($siteMapAdapters[$curCode])){
            $xml = $sitemap->getMapXml($curCode);
        }else{
            $xml = $sitemap->getIndexXml();
        }

        $this->response->header('Content-type: text/xml; charset=utf-8');
        $this->response->put($xml);
        $this->response->send();
    }
}