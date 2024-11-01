<?php
if ( !defined( 'ABSPATH' ) ) exit;
add_filter( 'woocommerce_payment_gateways_settings',  'wc_chinese_style_settings' );
		function wc_chinese_style_settings( $settings ){
			$insert_at = 0;
			foreach( $settings as $key => $setting ){
				if( $setting['type'] == 'sectionend' && $setting['id'] == 'checkout_process_options' )
					$insert_at = $key;
			}
			array_splice( $settings,
						  $insert_at,
						  0,
						  array(
						  	array(
						  		'id'            => 'woocommerce_chinese_style',
							  	'title'         => '结算页面输入栏风格',
								'desc'          => '推荐方式！',
								'default'       => 'redirect',
								'type'          => 'radio',
								'options'       => array(

									's2'     => '顾客先选择省/直辖市/自治区,输入城市,然后输入下一级地址。',
									's1'  =>'顾客输入完整的详细地址。',
								),
								'desc_tip'      =>  true,
								'autoload'      => false
							),

							array(
								'id'       => 'wc_cn_name_class',
								'title'         => '姓名输入容器的CSS class',
								'desc'     => '请输入CSS class名称',
								'desc_tip'      =>  true,
								'type'     => 'text',
								'default'  => 'wc-cn-name',

								'autoload' => false
							),
							array(
								'id'       => 'wc_cn_add_class',
								'title'         => '地址输入容器的CSS class',
								'desc'     => '请输入CSS class名称',
								'desc_tip'      =>  true,
								'type'     => 'text',
								'default'  => 'wc-cn-add',

								'autoload' => false
							),
							array(
								'id'       => 'wc_cn_country_class',
								'title'         => '国家选择容器的CSS class',
								'desc'     => '请输入CSS class名称',
								'desc_tip'      =>  true,
								'type'     => 'text',
								'default'  => 'wc-cn-country',
								'autoload' => false
							),
							array(
								'id'       => 'wc_cn_province_class',
								'title'         => '省份选择容器的CSS class',
								'desc'     => '请输入CSS class名称',
								'desc_tip'      =>  true,
								'type'     => 'text',
								'default'  => 'wc-cn-province',
								'autoload' => false
							),
							array(
								'id'       => 'wc_cn_ps_class',
								'title'         => '邮编输入器的CSS class',
								'desc'     => '请输入CSS class名称',
								'desc_tip'      =>  true,
								'type'     => 'text',
								'default'  => 'wc-cn-ps',
								'autoload' => false
							),
							array(
								'id'       => 'wc_cn_city_class',
								'title'         => '城市输入容器的CSS class',
								'desc'     => '请输入CSS class名称',
								'desc_tip'      =>  true,
								'type'     => 'text',
								'default'  => 'wc-cn-city',
								'autoload' => false
							),
							array(
								'id'       => 'wc_cn_express',
								'title'         => '是否显示快递方式',
								'desc'     => '是否显示快递方式',

								'type'     => 'checkbox',
								'default'  => 'yes',
								'autoload' => false
							),


			  	));
			return $settings;
		}