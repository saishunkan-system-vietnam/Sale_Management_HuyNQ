<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class attributesComponent extends Component {
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

    public function selectAll(){
    	$attributes = $this->Attributes->find('all')->where(['parent_id'=> 0])->toArray();
        foreach ($attributes as $attribute) {
            $attr = $this->Attributes->find('all')->where(['parent_id'=> $attribute['id']])->toArray();
            $attribute['options'] = $attr;
        }

        return $attributes;
    }

    public function selectChild(){
        $attrChilds = $this->Attributes->find()->where(['parent_id !=' => 0])->toArray();
        $attrParents = $this->Attributes->find()->where(['parent_id' => 0])->toArray();
        foreach ($attrChilds as $attrChild) {
            foreach ($attrParents as $attrParent) {
                if($attrChild->parent_id == $attrParent->id){
                    $attrChild['parent_name'] = $attrParent->name;
                }
            }
        }
        return $attrChilds;
    }

    public function checkParent($id = null){
        $parent_id = $this->Attributes->find()->where(['id' => $id])->first()->parent_id;
        if($parent_id == 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function update($reqAttribute){
        $result = $this->Attributes->query()->update()
        ->set(['name' => $reqAttribute['name'],
               'parent_id' => $reqAttribute['attribute']
              ])
        ->where(['id' => $reqAttribute['id']])
        ->execute();
        return $result;
    }
}
?>

