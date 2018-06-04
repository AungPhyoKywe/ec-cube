<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Tests\Form\Type\Admin;

use Eccube\Form\Type\Admin\ShopMasterType;
use Eccube\Tests\Form\Type\AbstractTypeTestCase;

class ShopMasterTypeTest extends AbstractTypeTestCase
{
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var array デフォルト値（正常系）を設定
     */
    protected $formData = [
        /*
        'company_name' => '会社名',
        'company_kana' => 'カナ',
         */
        'shop_name' => '店舗名',
        /*
        'shop_kana' => 'カナ',
        'shop_name_eng' => 'shopname',
        'zip' => array(
            'zip01' => '530',
            'zip02' => '0001',
        ),
        'address' => array(
            'pref' => '5',
            'addr01' => '北区',
            'addr02' => '梅田',
        ),
         */
        'tel' => [
            'tel01' => '03',
            'tel02' => '1111',
            'tel03' => '1111',
        ],
        'fax' => [
            'fax01' => '03',
            'fax02' => '1111',
            'fax03' => '4444',
        ],
        /*
        'business_hour' => '店舗営業時間',
         */
        'email01' => 'eccube@example.com',
        'email02' => 'eccube@example.com',
        'email03' => 'eccube@example.com',
        'email04' => 'eccube@example.com',
        'delivery_free_amount' => '1000',
        'delivery_free_quantity' => '1000',
        /*
        'good_traded' => '取り扱い商品',
        'message' => 'メッセージ',
        'option_product_delivery_fee' => '0',
        'option_delivery_fee' => '0',
        'option_customer_activate' => '0',
        'option_mypage_order_status_display' => '0',
        'option_favorite_product' => 0,
        'option_remember_me' => '0',
        'option_nostock_hidden' => '0',
         */
    ];

    public function setUp()
    {
        parent::setUp();

        // CSRF tokenを無効にしてFormを作成
        $this->form = $this->formFactory
            ->createBuilder(ShopMasterType::class, null, ['csrf_protection' => false])
            ->getForm();
    }

    public function testValidData()
    {
        $this->form->submit($this->formData);
        $this->assertTrue($this->form->isValid());
        // エラーメッセージデバッグ用
        //var_dump($this->form->getErrorsAsString());die;
    }

    public function testValidFax_Blank()
    {
        $this->formData['fax']['fax01'] = '';
        $this->formData['fax']['fax02'] = '';
        $this->formData['fax']['fax03'] = '';

        $this->form->submit($this->formData);
        $this->assertTrue($this->form->isValid());
    }

    public function testValidTel_Blank()
    {
        $this->formData['tel']['tel01'] = '';
        $this->formData['tel']['tel02'] = '';
        $this->formData['tel']['tel03'] = '';

        $this->form->submit($this->formData);
        $this->assertTrue($this->form->isValid());
    }

    public function testInValidDeliveryFreeAmount_OverMaxLength()
    {
        $this->formData['delivery_free_amount'] = '12345678900';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInValidDeliveryFreeAmount_NotNumeric()
    {
        $this->formData['delivery_free_amount'] = 'abcde';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInValidDeliveryFreeAmount_HasMinus()
    {
        $this->formData['delivery_free_amount'] = '-12345';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInValidDeliveryFreeQuantity_NotNumeric()
    {
        $this->formData['delivery_free_quantity'] = 'abcde';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInValidDeliveryFreeQuantity_HasMinus()
    {
        $this->formData['delivery_free_quantity'] = '-12345';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }
}
