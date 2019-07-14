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
    private $connection;
    private $ProductAttributes;
    private $ProductImages;
    private $ProductCategories;
    private $Categories;
    public function initialize()
    {
        parent::initialize();  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->ProductImages=TableRegistry::getTableLocator()->get('ProductImages');
        $this->ProductCategories=TableRegistry::getTableLocator()->get('ProductCategories');
        $this->Categories=TableRegistry::getTableLocator()->get('Categories');
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
            $attr = $this->Attributes->find('all')->where(['id'=> $attribute->attribute_id])->first();    
            array_push($product['options'], $attr);
        }

        foreach ($product['options'] as $option) {
            $attrParent = $this->Attributes->find('all')->where(['id'=> $option->parent_id])->first()->name;
            $option['parent_name'] = $attrParent;
        }

        $this->set(compact('product'));
    }

    public function add()
    {   
        $attributes = $this->Attributes->find('all')->where(['parent_id'=> 0])->toArray();

        foreach ($attributes as $attribute) {
            $attr = $this->Attributes->find('all')->where(['parent_id'=> $attribute['id']])->toArray();
            $attribute['options'] = $attr;
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
                $this->connection->begin();
                $this->connection->execute('INSERT INTO products (user_id,name,price,quantity,description,created,modified) VALUES (?,?,?,?,?,?,?)', 
                    [$request['user_id'], $request['name'],$request['price'],$request['quantity'],$request['description'],new DateTime('now'),new DateTime('now')],
                    ['integer','string','integer','integer','string','date','date']);

                $product = $this->Products->find()->where(['name'=> $request['name']])->first();

                $removeAttrs = array("user_id","name","quantity","price","description");

                foreach($removeAttrs as $key) {
                    unset($request[$key]);
                }

                foreach ($request as $req) {
                    $this->connection->execute('INSERT INTO product_attributes (attribute_id,product_id) VALUES (?,?)', 
                        [$req, $product->id],
                        ['integer','integer']);
                }
                $result = $this->connection->commit();

                if ($result) {
                    $this->Flash->success(__('The product has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $categories = $this->Categories->find()->where(['parent_id'=>1])->toArray();


        $this->set(compact('attributes','categories'));
    }

    public function edit($id = null)
    {
        $product = $this->Products->get($id);
        $attributes = $this->ProductAttributes->find('all')->where(['product_id'=> $id])->toArray();

        $product['options'] = array();

        foreach ($attributes as $attribute) {
            $attr = $this->Attributes->find('all')->where(['id'=> $attribute->attribute_id])->first();    
            array_push($product['options'], $attr);
        }

        foreach ($product['options'] as $option) {
            $attrParent = $this->Attributes->find('all')->where(['id'=> $option->parent_id])->first();
            $option['parent_name'] = $attrParent->name;
            $option['options'] = $this->Attributes->find('all')->where(['parent_id'=> $attrParent->id])->toArray();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->request->getData();

            $this->connection->begin();
            $this->connection->execute('UPDATE products SET name=?,price=?,quantity=?,description=?,modified=? WHERE id=?', 
                [$request['name'],$request['price'],$request['quantity'],$request['description'],new DateTime('now'),$id],
                ['string','integer','integer','string','date','integer']);

            $removeAttrs = array("user_id","name","quantity","price","description");

            foreach($removeAttrs as $key) {
                unset($request[$key]);
            }

            $this->connection->execute('DELETE FROM product_attributes WHERE product_id = ?',[$id],['integer']);

            foreach ($request as $req) {
                $this->connection->execute('INSERT INTO product_attributes (attribute_id,product_id) VALUES (?,?)', 
                    [$req, $id],
                    ['integer','integer']);
            }

            $result = $this->connection->commit();

            if ($result) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $this->set(compact('product', 'attributes'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->connection->begin();
        $this->connection->execute('DELETE FROM products WHERE id = ?',[$id],['integer']);
        $this->connection->execute('DELETE FROM product_attributes WHERE product_id = ?',[$id],['integer']);
        $result = $this->connection->commit();
        if ($result) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function image($id = null){
        $images = $this->ProductImages->find('all')->where(['product_id'=>$id])->toArray();
        foreach ($images as $image) {
            $nameImage = $this->Images->find('all')->where(['id'=>$image['image_id']])->first()->name;
            $image['name'] = $nameImage;
        }
        // echo "<pre>";
        // print_r($images);
        // echo "</pre>";
        // die('a');
        if(isset($_POST["Submit"]))
        {
            if($_FILES["file"]["error"] == UPLOAD_ERR_NO_FILE){
                $this->Flash->success("Please, Select the file to upload!!!");
            }
            else{
                $name = explode('.', $_FILES["file"]["name"]);
                $newName = $name[0].'_'.rand(000000, 999999).'.'.$name[1];
                $this->connection->begin();
                    $this->connection->execute('INSERT INTO images (name) VALUES (?)', [$newName],['string']);
                    $img_id = $this->Images->find('all')->where(['name'=> $newName])->first()->id;
                    $this->connection->execute('INSERT INTO product_images (image_id,product_id) VALUES (?,?)', [$img_id, $id],['integer', 'integer']);
                    move_uploaded_file($_FILES["file"]["tmp_name"], "img/".$newName);
                $result = $this->connection->commit();
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
        $product_id = $this->ProductImages->find('all')->where(['image_id'=>$id])->first()->product_id;
        $this->request->allowMethod(['post', 'delete']);
        $this->connection->execute('DELETE FROM product_images WHERE image_id = ?',[$id],['integer']);
        $this->connection->execute('DELETE FROM images WHERE id = ?',[$id],['integer']);
        $this->Flash->success("Image deleted !!!");

        return $this->redirect(['action' => 'image', $product_id]);
    }
}
