<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

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

    public function getCategories($category)
    {
        $categories = TableRegistry::getTableLocator()->get('Categories');
        foreach ($category as $cate) {
            $check = $categories->find()->where(['parent_id' => $cate['id']])->toArray();
            if ($check) {
                echo '<li class="dropdown side-dropdown">';
                echo '<a class="col-md-6" href="/search/category='.$cate['id'].'">'.$cate['name'].' </a><a class="dropdown-toggle col-md-6" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-angle-right"></i></a>';
                echo '<div class="custom-menu">';
                echo '<div class="row">';
                $result = $categories->find()->where(['parent_id' => $cate['id']])->toArray();
                foreach ($result as $value) {
                    echo '<div class="col-md-4">';
                    echo '<ul class="list-links">';
                    echo '<li><a href="/search/category='.$value['id'].'" class="list-links-title"><b>'.$value['name'].'</b></a></li>';
                    $descendants = $categories->find('children', ['for' => $value['id']]);

                    foreach ($descendants as $des) {
                        echo '<li><a href="/search/category='.$des['id'].'">'.$des->name.'</a></li>'. "\n";
                    }
                    echo '</ul>';
                    echo '<hr class="hidden-md hidden-lg">';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
                echo '</li>';
            }else {
                echo '<li><a href="/search/category='.$cate['id'].'">'.$cate['name'].'</a></li>';
            }
        }    
    }
}

?>