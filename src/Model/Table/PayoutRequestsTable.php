<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PayoutRequests Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\PayoutRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\PayoutRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PayoutRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PayoutRequest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PayoutRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PayoutRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PayoutRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PayoutRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class PayoutRequestsTable extends Table
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

        $this->setTable('payout_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('start_date')
            ->allowEmptyDateTime('start_date');

        $validator
            ->dateTime('end_date')
            ->allowEmptyDateTime('end_date');

        $validator
            ->integer('referral_count')
            ->allowEmptyString('referral_count');

        $validator
            ->integer('total')
            ->allowEmptyString('total');

        $validator
            ->scalar('status')
            ->maxLength('status', 45)
            ->allowEmptyString('status');

        $validator
            ->integer('referral_count_2')
            ->allowEmptyString('referral_count_2');

        $validator
            ->integer('referral_count_3')
            ->allowEmptyString('referral_count_3');

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

        return $rules;
    }
}
