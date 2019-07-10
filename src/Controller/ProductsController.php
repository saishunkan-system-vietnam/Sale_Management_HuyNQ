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
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->viewBuilder()->layout("home");   
    }

    public function index()
    {
        $products = $this->paginate($this->Products);
        // echo "<pre>";
        // print_r($products);
        // echo "</pre>";
        // die('a');
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
