<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;
use Cake\View\Helper;
use Cake\Database\Expression\QueryExpression;

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
    private $Images;
    private $ProductAttributes;
    private $Categories;
    private $Sales;

    public function initialize()
    {   
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes = TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->Sales = TableRegistry::getTableLocator()->get('Sales');
        $this->loadComponent('products');
        $this->loadComponent('attributes');
        $this->loadComponent('categories');
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("admin");
    }

    public function index()
    {      
        $this->paginate = [
            'maxLimit' => 10
            ];
        $categories = $this->Categories->find()->toArray();
        
        $products = $this->paginate($this->products->selectCategories());
        
        $this->set(compact('products','categories'));
    }

    public function view($id = null)
    {
        $images = $this->Images->find('all')->where(['product_id'=>$id])->toArray();
        $product = $this->Products->get($id);
        $attributes = $this->ProductAttributes->find('all')->where(['product_id'=> $id])->toArray();
        $product['options'] = array();

        foreach ($attributes as $attribute) {
            if($attribute->attribute_id !== null){
                $attr = $this->Attributes->find('all')->where(['id'=> $attribute->attribute_id])->first();    
                array_push($product['options'], $attr);
            }
        }

        foreach ($product['options'] as $option) {
            if($option !== null){
                $attrParent = $this->Attributes->find('all')->where(['id'=> $option->parent_id])->first()->name;
                $option['parent_name'] = $attrParent;
            }
        }

        $this->set(compact('product','images'));
    }

    public function add()
    {   
        $session = $this->getRequest()->getSession();
        $user = $session->read('Auth.Admin');
        $attributes = $this->attributes->selectAll();
        $categories = $this->Categories->find()->toArray();
        
        if ($this->request->is('post')) {
            $session = $this->getRequest()->getSession();
            $request = $this->request->getData();
            $session->write('Infor', $request);
            $validation = $this->Products->newEntity($request);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }else{
                $request['user_id'] = $user['id'];
                $this->connection->begin();
                $product = $this->products->add($request);
                $id = $product->id;
                $removeAttrs = array("user_id","name","quantity","price","description","category_id",'status');

                foreach($removeAttrs as $key) {
                    unset($request[$key]);
                }

                foreach ($request as $req) {
                    if($req !== "null"){
                        $this->ProductAttributes->query()->insert(['attribute_id', 'product_id'])
                        ->values([
                            'attribute_id' => $req,
                            'product_id' => $id
                        ])
                        ->execute();
                    }
                }
                $result = $this->connection->commit();

                if ($result) {
                    $this->Flash->success(__('The product has been saved.'));
                    $session->delete('Infor');
                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $this->set(compact('attributes','categories'));
    }

    public function edit($id = null)
    {
        $images = $this->Images->find('all')->where(['product_id'=>$id])->toArray();

        $product = $this->Products->get($id);
        $category_id = $product['category_id'];
        $categories = $this->Categories->find()->toArray(); 
        $product['category_parent'] = $this->Categories->find()->where(['id'=>$product->category_id])->first()->parent_id;

        $attributes = $this->attributes->selectAll();
        foreach ($attributes as $attribute) {
            foreach ($attribute['options'] as $attr) {
                $result = $this->ProductAttributes->find()->where(['attribute_id'=>$attr['id'],'product_id'=>$id])->first()['attribute_id'];
                if(!empty($result)){
                    $attribute['product_attr'] = $result;
                }
            }
        }
 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();
            // echo "<pre>";
            // print_r($request['file']);
            // die('a');
            $request['user_id'] = $this->Auth->user('id');
            $request['id'] = $id;
            if($request['file']){
                $result = $this->products->checkImage($request['file']);
            }
            $validation = $this->Products->newEntity($request);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }elseif (isset($result) && $result!==1) {
                $this->set('errimage',$result);
            }else{
                $this->connection->begin();
                
                $this->products->update($request);

                if ($request['file'][0]['type'] != "") {
                    foreach ($request['file'] as $value) {
                        $name = explode('.', $value["name"]);
                        $newName = $name[0].'_'.rand(000000, 999999).'.'.$name[1];

                        $reqImage = array('name'=>$newName,'product_id'=>$id);
                        $this->products->addImage($reqImage);
                        move_uploaded_file($value["tmp_name"], "img/".$newName);
                    }
                }
                
                $removeAttrs = array("id","user_id","name","quantity","price","description","status","category_id","file");

                foreach($removeAttrs as $key) {
                    unset($request[$key]);
                }

                $this->ProductAttributes->query()->delete()->where(['product_id' => $id])->execute();
                foreach ($request as $req) {
                    if(!empty($req)){
                        
                        $this->ProductAttributes->query()->insert(['attribute_id', 'product_id'])
                        ->values([
                            'attribute_id' => $req,
                            'product_id' => $id
                        ])
                        ->execute();
                    }
                }
                $result = $this->connection->commit();

                if ($result) {
                    $this->Flash->success(__('The product has been saved.'));

                    return $this->redirect(['action' => 'edit', $id]);
                }
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('product', 'attributes','categories','images','category_id'));
    }

    public function delete($id = null)
    {
        // $this->request->allowMethod(['post', 'delete']);
        $this->connection->begin();
            $query = $this->Products->query();
            $result = $query->update()
            ->set(['status' => 0,'modified' => new DateTime('now')])
            ->where(['id' => $id])
            ->execute();
            // $images = $this->Images->find()->where(['product_id'=>$id])->toArray();
            // foreach ($images as $image) {
            //     unlink('img/'.$image['name']);
            // }
            // $this->Images->query()->delete()->where(['product_id' => $id])->execute();
            // $this->ProductAttributes->query()->delete()->where(['product_id' => $id])->execute();
            // $this->Products->query()->delete()->where(['id' => $id])->execute();
        $result = $this->connection->commit();
        if ($result) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function restore($id = null)
    {
        $this->connection->begin();
            $query = $this->Products->query();
            $result = $query->update()
            ->set(['status' => 1,'modified' => new DateTime('now')])
            ->where(['id' => $id])
            ->execute();
        $result = $this->connection->commit();
        if ($result) {
            $this->Flash->success(__('The product has been restored.'));
        } else {
            $this->Flash->error(__('The product could not be restored. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deleteImage($id = null){
        $product = $this->Images->find('all')->where(['id'=>$id])->first();
        // $this->request->allowMethod(['post', 'delete']);
        unlink('img/'.$product->name);
        $result = $this->Images->query()->delete()->where(['id' => $id])->execute();
        if($result){
            $this->Flash->success("Image deleted successfully!!!");
        }else{
            $this->Flash->success("Image deleted fail !!!");
        }
        return $this->redirect(['action' => 'edit', $product['product_id']]);
    }

    public function search(){
        $this->viewBuilder()->autoLayout(false);
        $request = $this->getRequest()->getData();
        if($request['data'] !== ""){
            $products = $this->paginate($this->Products->find()->where(['name LIKE' => '%' . $request['data'] . '%']));            
        }
        $this->set(compact('products'));
    }

    public function searchCate(){
        $this->viewBuilder()->autoLayout(false);
        if($this->request->is('post')){
            $request = $this->request->getData();
            $array = $this->Categories->find()->where(['parent_id'=>$request['category_id']])->toArray();

            if(!empty($array)){
                $data = $this->getChild($array);
                $data = explode(',', $data);
                $data[0] = $request['category_id'];
            }else{
                $data[] = $request['category_id'];
            }

            $products = $this->Products->find()->where(['category_id IN' => $data])->toArray();
            foreach ($products as $product) {
                $category = $this->Categories->find()->where(['id'=>$product['category_id']])->first()->name;
                $product['category'] = $category;
            }
            
        }
        $this->set(compact('products'));
    }

    public function getChild($array)
    {
      $data = "";
      foreach($array as $key => $element)
      {
        $data = $data.",".$element['id'];
        $result = $this->Categories->find()->where(['parent_id'=>$element['id']])->toArray();
        if(!empty($result))
        {
          $data = $data."".$this->getChild($result);
        }
      }
      return $data;
    }

    public function sale($id = null)
    {
        $sale = $this->Sales->newEntity();
        $request = $this->request->getData();
        $check = $this->Sales->find()->where(['product_id' => $id])->first();
        // echo "<pre>";
        // print_r($check);
        // die('a');
        if ($this->request->is('post')) {
            $request['product_id'] = $id;
            $sale = $this->Sales->patchEntity($sale, $request);
            $validation = $this->Sales->newEntity($request);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->Flash->error($error);
                    }
                }
            }else{
                if ($this->Sales->save($sale)) {
                    $this->Flash->success(__('The sale has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The sale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('sale', 'check'));
    }
}
