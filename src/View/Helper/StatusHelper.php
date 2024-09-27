<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class StatusHelper extends Helper
{
	public function checkStatus($status)
	{
		if($status == 1){
			echo "<b>Not Processing</b>";
		}elseif($status == 2){
			echo '<b style="color: orange;">Processing</b>';
		}elseif($status == 3){
			echo '<b style="color: green;">Successfull</b>';
		}else{
			echo '<b style="color: red;">Cancel</b>';
		}
	}
}
?>