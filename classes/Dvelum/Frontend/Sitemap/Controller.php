<?php
class Dvelum_Frontend_Sitemap_Controller extends Frontend_Controller
{
    public function indexAction()
    {
        $curCode = Request::getInstance()->getPart(1);
        $sitemap = new Dvelum_Sitemap($this->_router);
        $sitemap->setUrl(Request::url([$this->_router->findUrl('dvelum_sitemap')],false));

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

        header('Content-type: text/xml; charset=utf-8');
        Response::put($xml);
        Application::close();
    }
}