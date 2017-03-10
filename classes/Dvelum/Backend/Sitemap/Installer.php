<?php
class Dvelum_Backend_Sitemap_Installer extends Externals_Installer
{
    /**
     * Install
     * @param Config_Abstract $applicationConfig
     * @param Config_Abstract $moduleConfig
     * @return boolean
     */
    public function install(Config_Abstract $applicationConfig, Config_Abstract $moduleConfig)
    {
        $userId = User::getInstance()->getId();

        $pagesModel = Model::factory('Page');
        $pageItem = $pagesModel->getList(false,['func_code' => 'dvelum_sitemap']);

        if(empty($pageItem))
        {
            try{
                $sitemapPage = new Db_Object('Page');
                $sitemapPage->setValues(array(
                    'code'=>'sitemap',
                    'is_fixed'=>1,
                    'html_title'=>'Sitemap XML',
                    'menu_title'=>'Sitemap XML',
                    'page_title'=>'Sitemap XML',
                    'meta_keywords'=>'',
                    'meta_description'=>'',
                    'parent_id'=>null,
                    'text' =>'',
                    'func_code'=>'dvelum_sitemap',
                    'order_no' => 1,
                    'show_blocks'=>false,
                    'published'=>false,
                    'published_version'=>0,
                    'editor_id'=>$userId,
                    'date_created'=>date('Y-m-d H:i:s'),
                    'date_updated'=>date('Y-m-d H:i:s'),
                    'author_id'=>$userId,
                    'blocks'=>'',
                    'theme'=>'default',
                    'date_published'=>date('Y-m-d H:i:s'),
                    'in_site_map'=>false,
                    'default_blocks'=>true
                ));

                if(!$sitemapPage->saveVersion(true, false))
                    throw new Exception('Cannot create sitemap page');

                if(!$sitemapPage->publish())
                    throw new Exception('Cannot publish sitemap page');

            }catch (Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
    }

    /**
     * Uninstall
     * @param Config_Abstract $applicationConfig
     * @param Config_Abstract $moduleConfig
     * @return boolean
     */
    public function uninstall(Config_Abstract $applicationConfig, Config_Abstract $moduleConfig)
    {
        $pagesModel = Model::factory('Page');
        $pageItems = $pagesModel->getList(false,['func_code' => 'dvelum_sitemap']);

        foreach($pageItems as $item)
        {
            try{
                $page = Db_Object::factory('Page', $item['id']);
                $page->unpublish();
            }catch (Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
    }
}