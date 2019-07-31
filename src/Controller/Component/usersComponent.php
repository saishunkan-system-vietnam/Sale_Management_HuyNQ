<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

class UsersComponent extends Component {
    private $Products;
    private $Users;
    private $Carts;
    private $CartDetails;
    private $Images;

    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Carts = TableRegistry::getTableLocator()->get('Carts');
        $this->CartDetails = TableRegistry::getTableLocator()->get('CartDetails');
        $this->Images = TableRegistry::getTableLocator()->get('Images');
        $this->connection = ConnectionManager::get('default');
    }

    public function update($reqUser){
        $query = $this->Users->query();
        $result = $query->update()
        ->set(['name' => $reqUser['name'],'phone' => $reqUser['phone'],'address' => $reqUser['address'],'type' => $reqUser['type'],'status' => $reqUser['status'],'modified' => new DateTime('now')])
        ->where(['id' => $reqUser['id']])
        ->execute();

        return $result;
    }

    public function addCart($user_id, $carts){
        
        $this->connection->begin();
        $cart_id = $this->Carts->find()->where(['user_id'=>$user_id])->first()['id'];
        $this->CartDetails->query()->delete()
            ->where(['cart_id' => $cart_id])
            ->execute();
        $this->Carts->query()->delete()
            ->where(['user_id' => $user_id])
            ->execute();

            $cart = $this->Carts->newEntity();
            $cart->user_id = $user_id;
            $cart->created = new DateTime();
            $cart->modified = new DateTime();

        if ($this->Carts->save($cart)) {
            $id = $cart->id;
        }

        foreach ($carts as $value) {
            $this->CartDetails->query()->insert(['cart_id', 'product_id','name','price','quantity','created','modified'])
            ->values([
                'cart_id' => $id,
                'product_id' => $value['id'],
                'name' => $value['name'],
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'created' => new DateTime(),
                'modified' => new DateTime()
            ])
            ->execute();
        }

        $result = $this->connection->commit();

        return $result;
    }

    public function showSession($user_id){
        $cart = $this->Carts->find()->where(['user_id'=>$user_id])->first();
        $cartDetail = $this->CartDetails->find()->where(['cart_id'=>$cart['id']])->toArray();
        $total = 0;
        foreach ($cartDetail as $value) {
            $total = $total + $value['price']*$value['quantity'];
            $value['image'] = $this->Images->find()->where(['product_id'=>$value['product_id']])->first()['name'];
        }
        $data = array('Cart'=>$cartDetail,'Total'=>$total);
        return $data;
    }
}
?>
