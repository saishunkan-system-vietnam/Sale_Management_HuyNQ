<?php 
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use DateTime;
use Cake\Mailer\Email;

class EmailComponent extends Component {
    private $Products;
    private $Attributes;
    private $Images;
    private $ProductAttributes;
    private $Categories;

    public function initialize(array $config)
    {
        parent::initialize($config);  
        $this->Products = TableRegistry::getTableLocator()->get('Products');
        $this->Attributes = TableRegistry::getTableLocator()->get('Attributes');
        $this->ProductAttributes=TableRegistry::getTableLocator()->get('ProductAttributes');
        $this->Images=TableRegistry::getTableLocator()->get('Images');
        $this->Categories=TableRegistry::getTableLocator()->get('Categories');

    }

    public function sendEmail($user, $cart, $total, $password=""){
        $email = new Email('default');
        $email->from(['hoanghung888@gmail.com' => 'EShop'])
                ->to($user['email'])
                ->template('email', 'default')
                ->emailFormat('html')
                ->subject('Successfull Order - EShop Message')
                ->setViewVars(['user' => $user,'cart'=>$cart,'total'=>$total,'password'=>$password])
                ->send(); 

        $email->from(['hoanghung888@gmail.com' => 'EShop'])
                ->to('huynq3697@gmail.com')
                ->template('email', 'default')
                ->emailFormat('html')
                ->subject('New Order - EShop Message')
                ->setViewVars(['user' => $user,'cart'=>$cart,'total'=>$total,'password'=>$password])
                ->send();                  
    }
}
?>
