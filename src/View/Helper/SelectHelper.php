<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class SelectHelper extends Helper
{
    public function showCategories($categories, $parent_id = 0, $char = '',$category_id = 0,$selected=0)
    {   
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parent_id)
            {   
                if($item['id'] == $category_id){
                    echo '<option selected value="'.$item['id'].'">';
                        echo $char . ' ' . $item['name'];
                    echo '</option>';
                }elseif($item['id'] ==$selected){
                    echo '<option selected value="'.$item['id'].'">';
                        echo $char . ' ' . $item['name'];
                    echo '</option>';
                }else{
                    echo '<option value="'.$item['id'].'">';
                        echo $char . ' ' . $item['name'];
                    echo '</option>';
                }
                 
                // Xóa chuyên mục đã lặp
                unset($categories[$key]);
                 
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                $this->showCategories($categories, $item['id'], $char.'--', $category_id,$selected);
            }
        }
    }
}

?>