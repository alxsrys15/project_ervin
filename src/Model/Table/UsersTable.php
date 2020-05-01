<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Ahc\Jwt\JWT;
use Cake\Routing\Router;
/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ReferredBy',[
            'className' => 'Users',
            'foreignKey' => 'referred_by',
            'propertyName' => 'referred_by'
        ]);

        $this->hasMany('UserPackages', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsToMany('Packages', [
            'propertyName' => 'packages',
            'joinTable' => 'user_packages' 
        ]);

        $this->belongsTo('Package', [
            'className' => 'Packages',
            'propertyName' => 'package',
            'foreignKey' => 'package_id'
        ]);

        $this->belongsTo('UserLevels', [
            'foreignKey' => 'user_level_id',
            'propertyName' => 'user_level'
        ]);

        $this->hasMany('UserInvestments', [
            'foreignKey' => 'user_id'
        ]);

        $this->hasMany('CommissionRequests', [
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        // $validator
        //     ->scalar('account_number')
        //     ->maxLength('account_number', 255)
        //     ->requirePresence('account_number', 'create')
        //     ->notEmptyString('account_number');

        // $validator
        //     ->scalar('bank_name')
        //     ->maxLength('bank_name', 45)
        //     ->requirePresence('bank_name', 'create')
        //     ->notEmptyString('bank_name');

        $validator
            ->integer('referred_by')
            ->allowEmptyString('referred_by');

        // $validator
        //     ->integer('user_level')
        //     ->requirePresence('user_level', 'create')
        //     ->notEmptyString('user_level');

        $validator
            ->scalar('referral_link')
            ->maxLength('referral_link', 255)
            ->allowEmptyString('referral_link');

        // $validator
        //     ->scalar('reference_number')
        //     ->maxLength('reference_number', 255)
        //     ->requirePresence('reference_number', 'create')
        //     ->notEmptyString('reference_number');

        $validator
            ->scalar('deposit_image')
            ->maxLength('deposit_image', 500)
            ->allowEmptyFile('deposit_image');

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

        return $rules;
    }

    public function afterSave ($event, $entity) {
        $jwt = new JWT('secret', 'HS256', 86400, 10);
        if ($entity->isNew()) {
            $token = $jwt->encode([
                'id' => $entity->id,
            ]);

            $link = Router::url(['controller' => 'Users', 'action' => 'register', '?' => ['referral' => $token]], true);

            $entity->referral_link = $link;
            if ($this->save($entity)) {
                
            }
        }
    }

    // public function findAuth (Query $query, array $options) {
    //     $query->where(['status' => 'Active']);

    //     return $query;
    // }

    public function getUserReferrals ($user_id) {
        $referrals = [
            'first' => [],
            'second' => [],
            'third' => []
        ];

        $query = $this->find('all', [ //first level
            'conditions' => [
                'referred_by' => $user_id
            ]
        ]);

        if ($query->count() > 0) {
            foreach ($query as $user) {
                $referrals['first'][] = $user->id;
            }
            $query = $this->find('all', [ //second level
                'conditions' => [
                    'referred_by IN' => $referrals['first']
                ]
            ]);

            if ($query->count() > 0) {
                foreach ($query as $user) {
                    $referrals['second'][] = $user->id;
                }

                $query = $this->find('all', [
                    'conditions' => [
                        'referred_by IN' => $referrals['second']
                    ]
                ]);

                if ($query->count() > 0) {
                    foreach ($query as $user) {
                        $referrals['third'][] = $user->id;
                    }
                }
            }
        }

        return $referrals;
    }

    public function getUplines ($user_id) {
        $uplines = [
            'first' => '',
            'second' => '',
            'third' => ''
        ];
        $user = $this->get($user_id);
        if ($user->referred_by) {
            $uplines['first'] = $user->referred_by;
            $second_up = $this->get($user->referred_by);
            if ($second_up->referred_by) {
                $uplines['second'] = $second_up->referred_by;
                $third_up = $this->get($second_up->referred_by);
                if ($third_up->referred_by) {
                    $uplines['third'] = $third_up->referred_by;
                }
            }
        }
        return $uplines;
    }
}
