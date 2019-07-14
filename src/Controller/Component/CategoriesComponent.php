<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class AttributesComponent extends Component {
    private $Attributes;
    private $Products;
    private $ProductAttributes;
    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes = TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->connection = ConnectionManager::get('default');
    }

    public function getData(){
        $attributes = $this->Attributes->find('all')->where(['parent_id'=> 0])->toArray();
        foreach ($attributes as $attribute) {
            $attr = $this->Attributes->find('all')->where(['parent_id'=> $attribute['id']])->toArray();
            $attribute['options'] = $attr;
        }

        return $attributes;
    }
}
?>
<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class CategoriesComponent extends Component {
    private $Categories;
    private $Products;
    private $ProductCategories;
    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->ProductCategories = TableRegistry::getTableLocator()->get('ProductCategories');
        $this->connection = ConnectionManager::get('default');
    }

    public function getData(){
        $categories = $this->Categories->find('all')->where(['parent_id'=> 0])->toArray();
        foreach ($categories as $category) {
            $cate = $this->Categories->find('all')->where(['parent_id'=> $category['id']])->toArray();
            $category['options'] = $cate;
        }

        return $categories;
    }
}
?>
