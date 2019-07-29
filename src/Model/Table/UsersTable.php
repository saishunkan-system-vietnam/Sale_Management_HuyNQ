<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \App\Model\Table\CartsTable|\Cake\ORM\Association\HasMany $Carts
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\HasMany $Products
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    private $Users;
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Carts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {   
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->allowEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->allowEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name','create',"Field is not isset")
            ->allowEmptyString('name', false, "Name cannot be empty");

        $validator
            ->integer('phone')
            ->allowEmptyString('phone')
            ->requirePresence('phone','create',"Field is not isset")
            ->allowEmptyString('phone', false, "phone cannot be empty");

        $validator
            ->scalar('address')
            ->maxLength('address', 100)
            ->requirePresence('address','create',"Field is not isset")
            ->allowEmptyString('address', false, "address cannot be empty");

        $validator
            ->integer('type')
            ->requirePresence('type','create',"Field is not isset");

        $validator
            ->scalar('notice')
            ->maxLength('notice', 100)
            ->requirePresence('notice','create',"Field is not isset")
            ->allowEmptyString('notice', false, "notice cannot be empty");

        return $validator;
    }

    public function validationPassword(Validator $validator)
    {
        $validator
            ->add('current_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if (md5($value) == $user->password) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'The old password does not match the current password!',
            ])
            ->notEmpty('current_password');

        $validator
            ->add('new_password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'The password have to be at least 6 characters!',
                ]
            ])
            ->add('new_password',[
                'match'=>[
                    'rule'=> ['compareWith','confirm_password'],
                    'message'=>'The passwords does not match!',
                ]
            ])
            ->notEmpty('new_password');

        $validator
            ->add('confirm_password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'The password have to be at least 6 characters!',
                ]
            ])
            ->add('confirm_password',[
                'match'=>[
                    'rule'=> ['compareWith','new_password'],
                    'message'=>'The passwords does not match!',
                ]
            ])
            ->notEmpty('confirm_password');

        return $validator;
    }

    public function validationAdd(Validator $validator){
        $validator
            ->email('email')
            ->allowEmptyString('email')
            ->requirePresence('email','create',"Field is not isset")
            ->allowEmptyString('email', false, "email cannot be empty")
            ->add('email','custom',[
                'rule'=>  function($value, $context){
                    $email = $this->find()->where(['email'=>$context['data']['email']])->first();
                    if (!isset($email)) {
                        return true;
                    }
                    return false;
                },
                'message'=>'This email was used !',
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->allowEmptyString('password')
            ->requirePresence('password','create',"Field is not isset")
            ->allowEmptyString('password', false, "password cannot be empty");

        $validator
            ->add('confirm_password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'The password have to be at least 6 characters!',
                ]
            ])
            ->add('confirm_password',[
                'match'=>[
                    'rule'=> ['compareWith','password'],
                    'message'=>'The passwords does not match!',
                ]
            ])
            ->notEmpty('confirm_password');

        return $validator;
    }
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
