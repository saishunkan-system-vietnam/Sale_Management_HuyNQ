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

    public function selectAll(){
    	$attributes = $this->Attributes->find('all')->where(['parent_id'=> 0])->toArray();
        foreach ($attributes as $attribute) {
            $attr = $this->Attributes->find('all')->where(['parent_id'=> $attribute['id']])->toArray();
            $attribute['options'] = $attr;
        }

        return $attributes;
    }
}
?>

