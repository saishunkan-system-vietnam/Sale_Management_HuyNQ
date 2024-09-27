<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\CartDetailsTable|\Cake\ORM\Association\HasMany $CartDetails
 * @property \App\Model\Table\ImagesTable|\Cake\ORM\Association\HasMany $Images
 * @property \App\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 * @property \App\Model\Table\ProductAttributesTable|\Cake\ORM\Association\HasMany $ProductAttributes
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->hasMany('CartDetails', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('Images', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('ProductAttributes', [
            'foreignKey' => 'product_id'
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name')
            ->requirePresence('name','create',"Field is not isset")
            ->allowEmptyString('name', false, "Name cannot be empty");

        $validator
            ->integer('price')
            ->allowEmptyString('price')
            ->requirePresence('price','create',"Field is not isset")
            ->allowEmptyString('price', false, "Price cannot be empty");

        $validator
            ->integer('quantity')
            ->allowEmptyString('quantity')
            ->requirePresence('quantity','create',"Field is not isset")
            ->allowEmptyString('quantity', false, "Quantity cannot be empty");

        $validator
            ->scalar('description')
            ->allowEmptyString('description')
            ->requirePresence('description','create',"Field is not isset")
            ->allowEmptyString('description', false, "Description cannot be empty");

        $validator
            ->integer('status')
            ->allowEmptyString('status')
            ->requirePresence('status','create',"Field is not isset");

        $validator
            ->scalar('category_id')
            ->requirePresence('category_id','create',"Field is not isset")
            ->allowEmptyString('category_id', false, "Category cannot be empty");
        
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));

        return $rules;
    }
}
