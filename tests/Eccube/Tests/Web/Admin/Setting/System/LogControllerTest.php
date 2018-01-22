<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Tests\Web\Admin\Setting\System;

use Eccube\Kernel;
use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;

/**
 * Class LogControllerTest
 * @package Eccube\Tests\Web\Admin\Setting\System
 */
class LogControllerTest extends AbstractAdminWebTestCase
{
    /** log Test   */
    protected $logTest;

    /** form Data   */
    protected $formData;

    public function setUp()
    {
        parent::setUp();

        $this->formData = array(
            '_token' => 'dummy',
            'files' => 'site_'.date('Y-m-d').'.log',
            'line_max' => '50',
        );

        /** @var Kernel $rootDir */
        $kernel= $this->container->get('kernel');

        $this->logTest = $kernel->getLogDir().'/'.$this->formData['files'];

        if (!file_exists($this->logTest)) {
            file_put_contents($this->logTest, 'test');
        }

    }

    /**
     * rollback
     */
    public function tearDown()
    {
        parent::tearDown();
        if (file_exists($this->logTest)) {
            unlink($this->logTest);
        }
    }

    /**
     * routing
     */
    public function testRoutingAdminSettingSystemLog()
    {
        $this->client->request(
            'GET',
            $this->generateUrl('admin_setting_system_log')
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * change log
     */
    public function testSystemLogSubmit()
    {
        $this->client->request(
            'POST',
            $this->generateUrl('admin_setting_system_log'),
            array('admin_system_log' => $this->formData)
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

}
