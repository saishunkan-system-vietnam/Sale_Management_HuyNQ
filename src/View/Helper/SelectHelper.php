<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class SelectHelper extends Helper
{
    public function showCategories($categories, $parent_id = 0, $char = '')
    {
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parent_id)
            {
                echo '<option value="'.$item['id'].'">';
                    echo $char . ' ' . $item['name'];
                echo '</option>';
                 
                // Xóa chuyên mục đã lặp
                unset($categories[$key]);
                 
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                $this->showCategories($categories, $item['id'], $char.'--');
            }
        }
    }

    public function text(){
    	echo "abcc";
    }
}

?>