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
        $products = $this->paginate($this->Products);
        $attributes = $this->Attributes->find('all')->toArray();

        $this->set(compact('products'));
    }

    public function view($id = null)
    {
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

        $this->set(compact('product'));
    }

    public function add()
    {   
        $attributes = $this->attributes->selectAll();
        $categories = $this->categories->selectAll();
        
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
                $this->connection->begin();
                $reqProduct = array('user_id'=>$request['user_id'],'name'=>$request['name'],'price'=>$request['price'],'quantity'=>$request['quantity'],'description'=>$request['description'],'category_id'=>$request['category'],'status'=>$request['status'],'created'=>new DateTime('now'),'modified'=>new DateTime('now'));
                $this->products->add($reqProduct);

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
                            'product_id' => $product->id
                        ])
                        ->execute();
                    }else{
                        $this->ProductAttributes->query()->insert(['attribute_id', 'product_id'])
                        ->values([
                            'attribute_id' => $req,
                            'product_id' => $product->id
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
        $product = $this->Products->get($id);
        $attributes = $this->ProductAttributes->find('all')->where(['product_id'=> $id])->toArray();
        $categories = $this->categories->selectAll();

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
 
            $this->connection->begin();
  
            $this->products->update($request);

            $removeAttrs = array("id","user_id","name","quantity","price","description");

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
        echo "<pre>";
        print_r($categories);
        echo "</pre>";
        die('a');

        $this->set(compact('product', 'attributes','categories'));
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
                $name = explode('.', $_FILES["file"]["name"]);
                $newName = $name[0].'_'.rand(000000, 999999).'.'.$name[1];

                $reqImage = array('name'=>$newName,'product_id'=>$id);
                $result = $this->products->addImage($reqImage);
                move_uploaded_file($_FILES["file"]["tmp_name"], "img/".$newName);

                if($result){
                    $this->Flash->success("File uploaded successfully!!!");
                    return $this->redirect(['action' => 'image', $id]);
                }else{
                    $this->Flash->success("File uploaded fail !!!");
                }       
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

        return $this->redirect(['action' => 'image', $product['product_id']]);
    }

    public function getcateChild($id = null){
        $cateChilds = $this->Categories->find()->where(['parent_id'=>$id])->toArray();

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($cateChilds));
    }
}
