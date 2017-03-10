<?php
class Dvelum_Sitemap_Pages extends Dvelum_Sitemap_Adapter
{
    public function getItemsXML()
    {
        $pagesModel = Model::factory('page');

        $list = $pagesModel->getList(array(
            'sort' => array(
                'parent_id' ,
                'order_no'
            ),
        ) , array(
            'published' => true ,
            'in_site_map' => true
        ) , array(
            'code' ,
            'func_code',
            'date_updated' => ' DATE_FORMAT(date_updated,"%Y-%m-%d")' ,
            'date_created' => ' DATE_FORMAT(date_created,"%Y-%m-%d")'
        ));

        $curDate = date('Y-m-d');

        $xml = '';
        foreach($list as $k => $v)
        {
            $url = Request::url([$v['code']]);

            if(!empty($v['func_code'])) {
                $xml .= $this->createItemXML($url, $curDate , self::CHANGEFREQ_DAILY, 0.9);
                continue;
            }

            if(strlen($v['date_updated'])) {
                $xml .= $this->createItemXML($url, $v['date_updated'], self::CHANGEFREQ_WEEKLY, 0.8);
            }else {
                $xml .= $this->createItemXML($url, $v['date_created'], self::CHANGEFREQ_WEEKLY, 0.8);
            }
        }
        return $xml;
    }
}