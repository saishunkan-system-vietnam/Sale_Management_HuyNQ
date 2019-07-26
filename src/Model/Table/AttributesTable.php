<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AttributesTable extends Table
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

        $this->setTable('attributes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentAttributes', [
            'className' => 'Attributes',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildAttributes', [
            'className' => 'Attributes',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ProductAttributes', [
            'foreignKey' => 'attribute_id'
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
            ->allowEmptyString('name');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    public function validationAttributes(Validator $validator)
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
            ->scalar('parent_id')
            ->allowEmptyString('parent_id', false, "Category cannot be empty");

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentAttributes'));

        return $rules;
    }
}
