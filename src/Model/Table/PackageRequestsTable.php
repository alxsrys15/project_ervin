<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PackageRequests Model
 *
 * @property \App\Model\Table\PackagesTable&\Cake\ORM\Association\BelongsTo $Packages
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\PackageRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\PackageRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PackageRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PackageRequest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PackageRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PackageRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PackageRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PackageRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class PackageRequestsTable extends Table
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

        $this->setTable('package_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Packages', [
            'foreignKey' => 'package_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('UserPackages', [
            'foreignKey' => 'package_id',
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
            ->scalar('bank_reference')
            ->maxLength('bank_reference', 45)
            ->allowEmptyString('bank_reference');

        $validator
            ->scalar('status')
            ->maxLength('status', 45)
            ->allowEmptyString('status');

        $validator
            ->integer('qty')
            ->allowEmptyString('qty');

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
        $rules->add($rules->existsIn(['package_id'], 'Packages'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
