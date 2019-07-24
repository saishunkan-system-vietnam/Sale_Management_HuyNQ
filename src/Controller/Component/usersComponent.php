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

    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Carts = TableRegistry::getTableLocator()->get('Carts');
        $this->CartDetails = TableRegistry::getTableLocator()->get('CartDetails');
        $this->connection = ConnectionManager::get('default');
    }

    public function addCart($user_id, $carts){
        
        $this->connection->begin();
            $cart = $this->Carts->newEntity();
            $cart->user_id = $user_id;
            $cart->created = new DateTime();
            $cart->modified = new DateTime();

        if ($this->Carts->save($cart)) {
            $id = $cart->id;
        }
        // echo "<pre>";
        // print_r($carts);
        // echo "</pre>";
        // die('a');
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
        }
        $data = array('Cart'=>$cartDetail,'Total'=>$total);
        return $data;
    }
}
?>
