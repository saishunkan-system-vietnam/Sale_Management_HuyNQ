<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use DateTime;

class HomeComponent extends Component {
    private $Categories;
    private $Products;
    private $Images;
    private $ProductAttributes;
    private $Users;
    private $Orders;
    private $OrderDetails;
    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->Images=TableRegistry::getTableLocator()->get('Users');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->OrderDetails=TableRegistry::getTableLocator()->get('OrderDetails');
        $this->connection = ConnectionManager::get('default');
    }

    public function addUser($reqUser){
        $result = $this->Users->query()->insert(['email', 'password', 'name', 'phone', 'address', 'type','notice','created','modified'])
                                    ->values([
                                        'email' => $reqUser['email'],
                                        'password' => $reqUser['password'],
                                        'name' => $reqUser['name'],
                                        'phone' => $reqUser['phone'],
                                        'address' => $reqUser['address'],
                                        'type' => 0,
                                        'notice' => 'user',
                                        'created' => new DateTime('now'),
                                        'modified' => new DateTime('now')
                                    ])
                                    ->execute();
        return $result;
    }

    public function addOrder($reqOrder, $user_id){
        $total = 0;
        foreach ($reqOrder as $value) {
            $total = $total + $value['price']*$value['quantity'];
        }
        $this->connection->begin();
        $result= $this->Orders->query()->insert(['user_id', 'name', 'phone', 'address', 'email','total','status','created','modified'])
                                    ->values([
                                        'user_id' => $user_id,
                                        'name' => $reqOrder['name'],
                                        'phone' => $reqOrder['phone'],
                                        'address' => $reqOrder['address'],
                                        'email' => $reqOrder['email'],
                                        'total' => $total,
                                        'status' => 0,
                                        'created' => new DateTime('now'),
                                        'modified' => new DateTime('now')
                                    ])
                                    ->execute();
                                    
        foreach ($reqOrder as $value) {
            $this->OrderDetails->query()->insert(['order_id', 'product_id', 'name', 'price', 'quantity','created','modified'])
                                    ->values([
                                        'user_id' => $user_id,
                                        'name' => $reqOrder['name'],
                                        'phone' => $reqOrder['phone'],
                                        'address' => $reqOrder['address'],
                                        'email' => $reqOrder['email'],
                                        'total' => $total,
                                        'status' => 0,
                                        'created' => new DateTime('now'),
                                        'modified' => new DateTime('now')
                                    ])
                                    ->execute();
        }

        $result = $this->connection->commit();

    }
}
?>
