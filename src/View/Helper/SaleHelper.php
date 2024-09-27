<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class SaleHelper extends Helper
{
	public function time($product)
	{
		$time_now = Time::now();
		$time = $time_now->i18nFormat('YYY-MM-dd HH-mm-ss');
		$sales = TableRegistry::getTableLocator()->get('Sales');
		$check = $sales->find()->where(['product_id' => $product['id'], 'status' => 1, 'startday <' => $time, 'endday >' => $time])->first();

		if (!empty($check)) {
			echo '<div class="product-label">';
			echo '<span class="sale">-'.$check['value'].'%</span>';
			echo '</div>';
			echo '<ul class="product-countdown time" endday="'.$check['endday'].'">';
			echo '<li class="day"><span>00 D</span></li>';
			echo '<li class="hour"><span>00 H</span></li>';
			echo '<li class="minute"><span>00 M</span></li>';
			echo '<li class="sec"><span>00 S</span></li>';
			echo '</ul>';
		}
	}

	public function price($product)
	{
		$sales = TableRegistry::getTableLocator()->get('Sales');
		$check = $sales->find()->where(['product_id' => $product['id'], 'status' => 1])->first();
		if (empty($check)) { 
			echo '<h3 class="product-price">'.number_format($product->price).' đ </h3>';
		} else { 
			echo '<h3 class="product-price">'.number_format($product->price - $product->price*$check->value/100).' đ <del class="product-old-price">'.number_format($product->price).' đ</del></h3>';
		}
	}
}
?>