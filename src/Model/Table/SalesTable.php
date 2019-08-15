<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sales Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\Sale get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sale newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sale|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sale[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sale findOrCreate($search, callable $callback = null, $options = [])
 */
class SalesTable extends Table
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

        $this->setTable('sales');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
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
            ->integer('value')
            ->allowEmptyString('value')
            ->requirePresence('value','create',"Field is not isset")
            ->allowEmptyString('value', false, "Value cannot be empty");

        $validator
            ->dateTime('startday')
            ->allowEmptyDateTime('startday')
            ->requirePresence('startday','create',"Field is not isset")
            ->allowEmptyString('startday', false, "Startday cannot be empty");

        $validator
            ->dateTime('endday')
            ->allowEmptyDateTime('endday')
            ->requirePresence('endday','create',"Field is not isset")
            ->allowEmptyString('endday', false, "Endday cannot be empty");

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    public function validationAdd(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->integer('value')
            ->allowEmptyString('value')
            ->requirePresence('value','create',"Field is not isset")
            ->allowEmptyString('value', false, "Value cannot be empty");
        $validator
            ->dateTime('startday')
            ->allowEmptyDateTime('startday')
            ->requirePresence('startday','create',"Field is not isset")
            ->allowEmptyString('startday', false, "Startday cannot be empty")
            ->add('startday','custom',[
                'rule'=>  function($value, $context){
                    $startday = strtotime(str_replace( 'T', ' ', $context['data']['startday']));
                    $endday = strtotime(str_replace( 'T', ' ', $context['data']['endday']));
                    if ($startday > $endday) {
                        return false;
                    } else {
                        return true;     
                    }  
                },
                'message'=>'Start Day must be before End Day!',
            ]);

        $validator
            ->dateTime('endday')
            ->allowEmptyDateTime('endday')
            ->requirePresence('endday','create',"Field is not isset")
            ->allowEmptyString('endday', false, "Endday cannot be empty");

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    public function validationEdit(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->integer('value')
            ->allowEmptyString('value')
            ->requirePresence('value','create',"Field is not isset")
            ->allowEmptyString('value', false, "Value cannot be empty");
        $validator
            ->dateTime('startday')
            ->allowEmptyDateTime('startday')
            ->requirePresence('startday','create',"Field is not isset")
            ->allowEmptyString('startday', false, "Startday cannot be empty")
            ->add('startday','custom',[
                'rule'=>  function($value, $context){
                    $startday = strtotime(str_replace( 'T', ' ', $context['data']['startday']));
                    $endday = strtotime(str_replace( 'T', ' ', $context['data']['endday']));
                    if ($startday > $endday) {
                        return false;
                    } else {
                        return true;     
                    }  
                },
                'message'=>'Start Day must be before End Day!',
            ]);

        $validator
            ->dateTime('endday')
            ->allowEmptyDateTime('endday')
            ->requirePresence('endday','create',"Field is not isset")
            ->allowEmptyString('endday', false, "Endday cannot be empty");

        $validator
            ->integer('status')
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
}
