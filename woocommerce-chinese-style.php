<?php
/**
 * Plugin Name: WooCommerce Chinese Style
 * Plugin URI:  http://suoling.net/woocommerce-chinese-style
 * Description: Let Woocommerce more suitable for Chinese people to use !
 * Version:     1.0
 * Author:      suifengtec
 * Author URI:  http://suoling.net
 */

if ( !defined( 'ABSPATH' ) ) exit;

$active_plugins = (array) get_option( 'active_plugins', array() );
if ( is_multisite() ){
	$active_plugins = array_merge($active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
}
if(in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins )){


	add_filter( 'default_checkout_country', 'wc_cn_style_change_default_country' );
	function wc_cn_style_change_default_country(){
		  return 'CN';
	}
	/*default provience*/
	add_filter( 'default_checkout_state', 'wc_cn_style_change_default_provience' );
	function wc_cn_style_change_default_provience(){
		$shop_location=get_option( 'woocommerce_default_country' );
		$provience=explode(':', $shop_location);
	  	return $provience[1];
	}
	/*default fileds on the checkout page*/
	add_filter('woocommerce_default_address_fields','wc_cn_style_default_checkout_fileds',11);
	function wc_cn_style_default_checkout_fileds( $fields){
		global $woocommerce;

		$name_class=get_option('wc_cn_name_class');
		$name_class=!empty($name_class)?trim($name_class):'';
		$add_class=get_option('wc_cn_add_class');
		$add_class=!empty($add_class)?trim($add_class):'';

		$country_class=get_option('wc_cn_country_class');
		$country_class=!empty($country_class)?trim($country_class):'';

		$province_class=get_option('wc_cn_province_class');
		$province_class=!empty($province_class)?trim($province_class):'';

		$ps_class=get_option('wc_cn_ps_class');
		$ps_class=!empty($ps_class)?trim($ps_class):'';

		$city_class=get_option('wc_cn_city_class');
		$city_class=!empty($city_class)?trim($city_class):'';

			$fields = array(
				'first_name'         => array(
					'label'    => '姓名',
					'required' => true,
					'class'    => array( 'form-row-wide',$name_class ),
					'order'         => '1',
				),

				'postcode'           => array(
					'label'       => '邮编',
					'placeholder' => '邮编',
					'required'    => true,
					'class'       => array( 'form-row-wide', 'address-field',$ps_class ),
					'clear'       => true,
					'validate'    => array( 'postcode' ),
					'order'         => '5',
				),


				'address_1'          => array(
					'label'       => '地址',
					'placeholder' => '输入地址...',
					'required'    => true,
					'class'       => array( 'form-row-wide', 'address-field',$add_class ),
					'order'         => '6',
				),



			);


			$fileds2=array(
				'country'     => array(
					'type'     => 'country',
					'label'    => '国家',
					'required' => false,
					'class'    => array( 'form-row-wide', 'address-field', 'update_totals_on_change','country_select' ,$country_class),
					'order'         => '2',
				),
				'state'              => array(
					'type'        => 'state',
					'label'       => '省/直辖市/自治区',
					'placeholder' => '省/直辖市/自治区',
					'required'    => false,
					'class'       => array( 'form-row-wide', 'address-field',$province_class ),
					'validate'    => array( 'state' ),

					'order'         => '3',
				),

				'city'              => array(
					'type'      => 	'text',
					'label'       => '城市',
					'placeholder' => '城市',
					'required'    => false,
					'class'       => array( 'form-row-wide',  'update_totals_on_change' ,$city_class),
					'order'         => '4',
				),

			);

		$style=get_option('woocommerce_chinese_style');
		if(isset($style)&&('s2'==$style)) $fields=array_merge($fields,$fileds2);
		return $fields;
	}

	/**
	*@author suifengtec
	* http://suoling.net/change-woocommerce-province-state-dropdown-list/
	*/
	if(!function_exists('wc_display_awesome_china_province')):

		add_filter( 'woocommerce_states', 'wc_display_awesome_china_province' );

		function wc_display_awesome_china_province($states) {

		$states['CN']=array(
							'CN1'  =>'云南',
							'CN2'  =>'北京',
							'CN3'  =>'天津',
							'CN4'  =>'河北',
							'CN5'  =>'山西',
							'CN6'  =>'内蒙古',
							'CN7'  =>'辽宁',
							'CN8'  =>'吉林',
							'CN9'  =>'黑龙江',
							'CN10' =>'上海',
							'CN11' =>'江苏',
							'CN12' =>'浙江',
							'CN13' =>'安徽',
							'CN14' =>'福建',
							'CN15' =>'江西',
							'CN16' =>'山东',
							'CN17' =>'河南',
							'CN18' =>'湖北',
							'CN19' =>'湖南',
							'CN20' =>'广东',
							'CN21' =>'广西',
							'CN22' =>'海南',
							'CN23' =>'重庆',
							'CN24' =>'四川',
							'CN25' =>'贵州',
							'CN26' =>'陕西',
							'CN27' =>'甘肃',
							'CN28' =>'青海',
							'CN29' =>'宁夏',
							'CN30' =>'澳门',
							'CN31' =>'西藏',
							'CN32' =>'新疆'
			);

		    return $states;

		}

	endif;


	add_filter( 'woocommerce_checkout_fields' , 'wc_chinese_express_add_to_checkout_page' );
	function wc_chinese_express_add_to_checkout_page( $fields ) {

		$show_cn_express=get_option('wc_cn_express');
		if(isset($show_cn_express)&&('no'!=$show_cn_express)){

		     $fields['billing']['billing_shipping_type']= array(
		    'type' => 'select',
		    'label'     =>'快递方式',
		    'placeholder'   => '请选择快递方式',
		    'required'  => true,
		    'class'     => array( 'form-row-wide', 'address-field', 'update_totals_on_change'),
		    'clear'     => true,
		     );
		     $fields['billing']['billing_shipping_type']['options'] = wc_chinese_express_methods();
		}

	     return $fields;
	}


		//Localization
	/*	add_filter('woocommerce_get_country_locale', 'wc_chinese_localization');
		function wc_chinese_localization($countries) {
			$countries['CN']['postcode_before_city']=true;
			$countries['CN']['state']['label']=__('District', 'woocommerce');
			return $countries;
		}*/
	/*chinese express fellows*/
	function wc_chinese_express_methods(){
		$arr=array(
	     	'sf' => '顺丰速运',
	     	'yt' => '圆通快递',
	     	'yd' => '韵达快递',
	     	'st' => '申通快递',
	     	'zj' => '宅急送',
	     	'bh' => '百世汇通',
	     	'ot' => '其它',
			);
		return apply_filters('wc_chinese_style_express_methods',$arr);
	}


	add_action('wp_head','wc_cn_express_style',99);
	function wc_cn_express_style(){
		if(is_checkout()){
		?><style>select#billing_shipping_type{
			position: relative;
	display: block;
	overflow: hidden;
	padding: 0 0 0 8px;
	height: 26px;
	border: 1px solid #aaa;
	border-radius: 5px;
	background: -webkit-gradient(linear,50% 0,50% 100%,color-stop(20%,#fff),color-stop(50%,#f6f6f6),color-stop(52%,#eee),color-stop(100%,#f4f4f4));
	background: -webkit-linear-gradient(top,#fff 20%,#f6f6f6 50%,#eee 52%,#f4f4f4 100%);
	background: -moz-linear-gradient(top,#fff 20%,#f6f6f6 50%,#eee 52%,#f4f4f4 100%);
	background: -o-linear-gradient(top,#fff 20%,#f6f6f6 50%,#eee 52%,#f4f4f4 100%);
	background: linear-gradient(top,#fff 20%,#f6f6f6 50%,#eee 52%,#f4f4f4 100%);
	background-clip: padding-box;
	box-shadow: 0 0 3px #fff inset,0 1px 1px rgba(0,0,0,.1);
	color: #444;
	text-decoration: none;
	white-space: nowrap;
		}
	</style><?php
		}
	}

	/*meta box init*/
	add_action('admin_init', 'wc_chinese_express_admin_init');
	function wc_chinese_express_admin_init() {
		$show_cn_express=get_option('wc_cn_express');
		if(isset($show_cn_express)&&('no'!=$show_cn_express)){
					add_meta_box( 'wc-china-express',
					'物流方式','wc_chinese_express_display_order_meta',
					'shop_order', 'side', 'high');
		}
	}
	/*output*/
	function wc_chinese_express_display_order_meta( $order ){
		 $text='<style>.wc-china-express{overflow: hidden;width:100%;position: relative;float: center;background: #ffffff;color: #A46497;text-align:center;vertical-align: middle;font-size:22px;font-size:2.2rem;line-height: 1.2em;font-weight: 700;}</style>';
		$text.=wc_chinese_express_get_post_shipping_type_label( $order );
		echo '<div class="wc-china-express">'.$text.'</div>';
	}
	/*main content*/
	function wc_chinese_express_get_post_shipping_type_label( $order ) {

		$method_id=get_post_meta($order->ID,'_billing_shipping_type',true);
		$shipping_types=wc_chinese_express_methods();
		foreach($shipping_types as $k=>$v) if($method_id==$k) return  $v;

	}


	/*change default time formart display on the admin order list page*/
	add_filter('post_date_column_time','wc_chinese_style',11,2);
	function wc_chinese_style($h_time, $post){

		global $post;
		$type=get_post_type($post);
		if('shop_order'==$type)
			$h_time   = get_the_time( 'Y-m-d H:i:s', $post );
		return $h_time;

	}


	add_filter ('add_to_cart_redirect', 'wc_chinese_style_redirect_to_checkout');

	function wc_chinese_style_redirect_to_checkout() {
	  global $woocommerce;
	  // Remove the default `Added to cart` message
	  $woocommerce->clear_messages();
	  // Redirect to checkout
	  $url = $woocommerce->cart->get_checkout_url();
	  return $url;
	}

	/*does not need to shipping to other address*/
	add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false' );


	add_action("template_redirect", 'wc_chinese_style_empty_cart_redirection');
	function wc_chinese_style_empty_cart_redirection(){
	    global $woocommerce;
	    if( is_cart() && sizeof($woocommerce->cart->cart_contents) == 0){
	        wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
	    }
	}


	require_once('settings.php');

}/*WooCommerce has be activated*/
?>