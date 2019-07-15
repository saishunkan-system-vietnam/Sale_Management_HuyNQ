<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class CategoriesComponent extends Component {
    private $Categories;
    private $Products;
    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->connection = ConnectionManager::get('default');
    }

    public function selectAll(){
        $categories = $this->Categories->find('all')->where(['parent_id'=> 0])->toArray();
        foreach ($categories as $category) {
            $cate = $this->Categories->find('all')->where(['parent_id'=> $category['id']])->toArray();
            $category['options'] = $cate;
        }

        return $categories;
    }
}
?>
