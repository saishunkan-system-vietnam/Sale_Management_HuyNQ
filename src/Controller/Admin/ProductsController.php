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

    public function initialize()
    {   
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->Categories=TableRegistry::getTableLocator()->get('Categories');
        $this->loadComponent('products');
        $this->loadComponent('attributes');
        $this->loadComponent('categories');
        $this->connection = ConnectionManager::get('default');
        $this->viewBuilder()->layout("admin");
    }

    public function index()
    {      
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
        $attributes = $this->attributes->selectAll();
        $categories = $this->Categories->find()->toArray();
        
        if ($this->request->is('post')) {
            $request = $this->request->getData();

            $validation = $this->Products->newEntity($request);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }else{
                $request['user_id'] = $this->Auth->user('id');
                $this->connection->begin();
                $product = $this->Products->newEntity();
                $product->user_id = $request['user_id'];
                $product->name = $request['name'];
                $product->price = $request['price'];
                $product->quantity = $request['quantity'];
                $product->description = $request['description'];
                $product->category_id = $request['category_id'];
                $product->status = $request['status'];
                $product->created = new DateTime('now');
                $product->modified = new DateTime('now');
                if ($this->Products->save($product)) {
                    $id = $product->id;
                }
                
                $product = $this->Products->find()->where(['name'=> $request['name']])->first();

                $removeAttrs = array("user_id","name","quantity","price","description","category",'status');

                foreach($removeAttrs as $key) {
                    unset($request[$key]);
                }

                foreach ($request as $req) {
                    if($req == "null"){
                        $req = null;
                        $this->ProductAttributes->query()->insert(['attribute_id', 'product_id'])
                        ->values([
                            'attribute_id' => $req,
                            'product_id' => $id
                        ])
                        ->execute();
                    }else{
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
        $attributes = $this->ProductAttributes->find('all')->where(['product_id'=> $id])->toArray();
        $categories = $this->Categories->find()->toArray(); 
        $product['category_parent'] = $this->Categories->find()->where(['id'=>$product->category_id])->first()->parent_id;

        $product['options'] = array();

        foreach ($attributes as $attribute) {
            if($attribute->attribute_id !== null){
                $attr = $this->Attributes->find('all')->where(['id'=> $attribute->attribute_id])->first();    
                array_push($product['options'], $attr);
            }
        }

        foreach ($product['options'] as $option) {
            $attrParent = $this->Attributes->find('all')->where(['id'=> $option->parent_id])->first();
            $option['parent_name'] = $attrParent->name;
            $option['options'] = $this->Attributes->find('all')->where(['parent_id'=> $attrParent->id])->toArray();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();

            $request['user_id'] = $this->Auth->user('id');
            $request['id'] = $id;
            $validation = $this->Products->newEntity($request);
            if($validation->getErrors()){  
                foreach ($validation->getErrors() as $key => $errors) {
                    foreach ($errors as $error) {
                        $this->set('err'.$key.'',$error);
                    }
                }
            }else{
                $this->connection->begin();
      
                $this->products->update($request);

                $removeAttrs = array("id","user_id","name","quantity","price","description","status","category");

                foreach($removeAttrs as $key) {
                    unset($request[$key]);
                }

                $this->ProductAttributes->query()->delete()->where(['product_id' => $id])->execute();

                foreach ($request as $req) {
                    $this->ProductAttributes->query()->insert(['attribute_id', 'product_id'])
                        ->values([
                            'attribute_id' => $req,
                            'product_id' => $product->id
                        ])
                        ->execute();
                }

                $result = $this->connection->commit();

                if ($result) {
                    $this->Flash->success(__('The product has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('product', 'attributes','categories','images','category_id'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->connection->begin();
            $images = $this->Images->find()->where(['product_id'=>$id])->toArray();
            foreach ($images as $image) {
                unlink('img/'.$image['name']);
            }
            $this->Images->query()->delete()->where(['product_id' => $id])->execute();
            $this->ProductAttributes->query()->delete()->where(['product_id' => $id])->execute();
            $this->Products->query()->delete()->where(['id' => $id])->execute();
        $result = $this->connection->commit();
        if ($result) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function image($id = null){
        $images = $this->Images->find('all')->where(['product_id'=>$id])->toArray();

        if(isset($_POST["Submit"]))
        {
            if($_FILES["file"]["error"] == UPLOAD_ERR_NO_FILE){
                $this->Flash->success("Please, Select the file to upload!!!");
            }
            else{
                $uploadOK = 1;

                foreach ($_FILES["file"]["size"] as $key => $value) {
                    if ($value > 500000) {
                        $name = $_FILES["file"]["name"][$key];
                        $this->Flash->success("Sorry, ".$name." is too large.");
                        $uploadOK = 0;
                    }
                }

                foreach ($_FILES["file"]["type"] as $key => $value) {
                    if($value != "image/jpeg" && $value != "image/png" && $value != "image/jpg") {
                        $name = $_FILES["file"]["name"][$key];
                        $this->Flash->success("Sorry, ".$name." files are not allowed. only JPG, JPEG, PNG & GIF");
                        $uploadOK = 0;
                    }
                }
                $result = "";
                if($uploadOK == 1){
                    $this->connection->begin();
                    $i = 0;
                    foreach ($_FILES["file"]["name"] as $value) {
                        $name = explode('.', $value);
                        $newName = $name[0].'_'.rand(000000, 999999).'.'.$name[1];

                        $reqImage = array('name'=>$newName,'product_id'=>$id);
                        $this->products->addImage($reqImage);
                        move_uploaded_file($_FILES["file"]["tmp_name"][$i], "img/".$newName);
                        $i++;
                    }
                    $result = $this->connection->commit();
                }
                
                if($result){
                    $this->Flash->success("File uploaded successfully!!!");
                }else{
                    $this->Flash->success("File uploaded fail !!!");
                }  
                return $this->redirect(['action' => 'edit', $id]);     
            }
        }
        $this->set(compact('images'));
    }

    public function deleteImage($id = null){
        $product = $this->Images->find('all')->where(['id'=>$id])->first();
        $this->request->allowMethod(['post', 'delete']);
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
        $categories = $this->categories->selectAll();
        if ($this->request->is('post')) {
            $request = $this->request->getData();

            if($request['name'] !== ""){
                $products = $this->paginate($this->products->selectCategories()->where(['products.name LIKE' => '%' . $request['name'] . '%']));            
            }

            if($request['name'] == ""){
                return $this->redirect(['action' => 'index']);
            }

        }
        $this->set(compact('products','categories'));
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
}
