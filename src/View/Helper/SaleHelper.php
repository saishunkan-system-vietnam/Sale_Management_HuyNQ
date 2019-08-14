<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class SaleHelper extends Helper
{
	public function checkSale($product)
	{
		$time_now = Time::now();
		$time = $time_now->i18nFormat('YYY-MM-dd HH-mm-ss');
		$sales = TableRegistry::getTableLocator()->get('Sales');
		$check = $sales->find()->where(['product_id' => $product['id'], 'status' => 1, 'startday <' => $time, 'endday >' => $time])->first();

		if (!empty($product['Sales']['id']) && !empty($check)) {
			echo '<div class="product-label">';
			echo '<span class="sale">-'.$product['Sales']['value'].'%</span>';
			echo '</div>';
			echo '<ul class="product-countdown time" endday="'.$product['Sales']['endday'].'">';
			echo '<li class="day"><span>00 D</span></li>';
			echo '<li class="hour"><span>00 H</span></li>';
			echo '<li class="minute"><span>00 M</span></li>';
			echo '<li class="sec"><span>00 S</span></li>';
			echo '</ul>';
		}
	}
}
?>