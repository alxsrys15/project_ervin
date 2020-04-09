<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CaptchaPayouts Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CaptchaPayout get($primaryKey, $options = [])
 * @method \App\Model\Entity\CaptchaPayout newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CaptchaPayout[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CaptchaPayout|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaptchaPayout saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CaptchaPayout patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CaptchaPayout[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CaptchaPayout findOrCreate($search, callable $callback = null, $options = [])
 */
class CaptchaPayoutsTable extends Table
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

        $this->setTable('captcha_payouts');
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
            ->date('date_start')
            ->allowEmptyDate('date_start');

        $validator
            ->date('date_end')
            ->allowEmptyDate('date_end');

        $validator
            ->integer('self_count')
            ->allowEmptyString('self_count');

        $validator
            ->integer('first_level_count')
            ->allowEmptyString('first_level_count');

        $validator
            ->integer('second_level_count')
            ->allowEmptyString('second_level_count');

        $validator
            ->integer('third_level_count')
            ->allowEmptyString('third_level_count');

        $validator
            ->integer('total')
            ->allowEmptyString('total');

        $validator
            ->scalar('status')
            ->maxLength('status', 45)
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
