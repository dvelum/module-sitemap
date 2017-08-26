<?php
/**
 *  DVelum project https://github.com/dvelum/dvelum
 *  Copyright (C) 2011-2017  Kirill Yegorov
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Dvelum\Sitemap\Adapter;

use Dvelum\Orm\Model;
use Dvelum\Request;
use Dvelum\Response;
use Dvelum\Sitemap\AbstractAdapter;

class Pages extends AbstractAdapter
{
    public function getItemsXML()
    {
        $pagesModel = Model::factory('page');

        $list = $pagesModel->query()
                            ->params(['sort' => ['parent_id', 'order_no']])
                            ->filters(['published' => true, 'in_site_map' => true])
                            ->fields( [
                                'code',
                                'func_code',
                                'date_updated' => ' DATE_FORMAT(date_updated,"%Y-%m-%d")',
                                'date_created' => ' DATE_FORMAT(date_created,"%Y-%m-%d")'
                            ])
                            ->fetchAll();

        $curDate = date('Y-m-d');

        $request = Request::factory();
        $xml = '';
        foreach ($list as $k => $v)
        {
            $url = $request->url([$v['code']]);

            if (!empty($v['func_code'])) {
                $xml .= $this->createItemXML($url, $curDate, self::CHANGEFREQ_DAILY, 0.9);
                continue;
            }

            if (strlen($v['date_updated'])) {
                $xml .= $this->createItemXML($url, $v['date_updated'], self::CHANGEFREQ_WEEKLY, 0.8);
            } else {
                $xml .= $this->createItemXML($url, $v['date_created'], self::CHANGEFREQ_WEEKLY, 0.8);
            }
        }
        return $xml;
    }
}