<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Products Controller
 *
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    private $Products;
    private $Images;
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->viewBuilder()->layout("home");   
    }

    public function index()
    {
        $products = $this->Products->find()->toArray();

        foreach ($products as $product) {
            $product['images'] = $this->Images->find()->where(['product_id'=>$product->id])->first()['name'];
        }

        $this->set(compact('products'));
    }

    public function view($id = null)
    {
        $product = $this->Products->get($id);

        $this->set(compact('product'));
    }

    public function checkout()
    {

    }
}
