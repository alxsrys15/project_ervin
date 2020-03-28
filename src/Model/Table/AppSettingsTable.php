<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AppSettings Model
 *
 * @method \App\Model\Entity\AppSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\AppSetting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AppSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AppSetting|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppSetting saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AppSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AppSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AppSetting findOrCreate($search, callable $callback = null, $options = [])
 */
class AppSettingsTable extends Table
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
        $this->primaryKey('id');
        $this->setTable('app_settings');
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
            ->integer('referral_value')
            ->requirePresence('referral_value', 'create')
            ->notEmptyString('referral_value');

        $validator
            ->integer('captcha_value')
            ->requirePresence('captcha_value', 'create')
            ->notEmptyString('captcha_value');

        return $validator;
    }
}
