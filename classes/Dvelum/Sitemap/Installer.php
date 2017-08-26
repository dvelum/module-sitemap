<?php
namespace Dvelum\Sitemap;

use Dvelum\Config\ConfigInterface;
use Dvelum\App\Session\User;
use Dvelum\Orm\Model;
use Dvelum\Orm\Object;

class Installer extends \Externals_Installer
{
    /**
     * Install
     * @param ConfigInterface $applicationConfig
     * @param ConfigInterface $moduleConfig
     * @return boolean
     */
    public function install(ConfigInterface $applicationConfig, ConfigInterface $moduleConfig)
    {
        $userId = User::getInstance()->getId();

        $pagesModel = Model::factory('Page');
        $pageItemExists = $pagesModel->query()->filters(['func_code' => 'dvelum_sitemap'])->getCount();

        if(!$pageItemExists)
        {
            try{
                $sitemapPage = Object::factory('Page');
                $sitemapPage->setValues([
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
                ]);

                if(!$sitemapPage->saveVersion(true, false))
                    throw new \Exception('Cannot create sitemap page');

                if(!$sitemapPage->publish())
                    throw new \Exception('Cannot publish sitemap page');

            }catch (\Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
    }

    /**
     * Uninstall
     * @param ConfigInterface $applicationConfig
     * @param ConfigInterface $moduleConfig
     * @return boolean
     */
    public function uninstall(ConfigInterface $applicationConfig, ConfigInterface $moduleConfig)
    {
        $pagesModel = Model::factory('Page');
        $pageItems = $pagesModel->query()->filters(['func_code' => 'dvelum_sitemap'])->fetchAll();

        foreach($pageItems as $item)
        {
            try{
                $page = Object::factory('Page', $item['id']);
                $page->unpublish();
            }catch (\Exception $e){
                $this->errors[] = $e->getMessage();
                return false;
            }
        }
    }
}