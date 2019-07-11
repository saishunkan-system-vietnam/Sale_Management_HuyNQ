<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

/**
 * Products Controller
 *
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    private $Products;
    private $Attributes;
    private $connection;
    private $ProductAttributes;
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
    }

    public function index()
    {
        $products = $this->paginate($this->Products);
        $attributes = $this->Attributes->find('all')->toArray();
 
        $this->set(compact('products'));
    }

    public function view($id = null)
    {
        $product = $this->Products->get($id);

        $this->set(compact('product'));
    }

    public function add()
    {   
        $attributes = $this->Attributes->find('all')->toArray();
        $attribute = $this->Attributes->find('all')->where(['parent_id'=> 0])->toArray();
  
        foreach ($attributes as $value) {
            foreach ($attribute as $attr) {
                if($attr['id'] == $value['parent_id']){
                    $attr['options'] = $value['name'];
                }
            }
        }

        if ($this->request->is('post')) {
            $request = $this->request->getData();
            $validation = $this->Products->newEntity($request);
            if($validation->getErrors()){
                foreach ($validation->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->success($error);
                    }
                }
            }else{
                $request['user_id'] = $this->Auth->user('id');
                $result = $this->connection->execute('INSERT INTO products (user_id,name,price,quantity,body,created,modified) VALUES (?,?,?,?,?,?,?)', 
                            [$request['user_id'], $request['name'],$request['price'],$request['quantity'],$request['body'],new DateTime('now'),new DateTime('now')],
                            ['integer','string','integer','integer','string','date','date']);
                if ($result) {
                    $this->Flash->success(__('The product has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        // echo "<pre>";
        // print_r($attribute);
        // echo "</pre>";
        // die('a');
        $this->set(compact('attributes'));
    }

    public function edit($id = null)
    {
        $product = $this->Products->get($id);
        $request = $this->request->getData();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $this->connection->execute('UPDATE products SET name=?,price=?,quantity=?,body=?,modified=? WHERE id=?', 
                            [$request['name'],$request['price'],$request['quantity'],$request['body'],new DateTime('now'),$id],
                            ['string','integer','integer','string','date','integer']);
            if ($result) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $result = $this->connection->execute('DELETE FROM products WHERE id = ?',[$id],['integer']);
        if ($result) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
