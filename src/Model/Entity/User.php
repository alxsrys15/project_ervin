<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $account_number
 * @property string $bank_name
 * @property int $user_level
 * @property string|null $referral_link
 * @property string $reference_number
 * @property string|null $deposit_image
 *
 * @property \App\Model\Entity\ReferredBy $referred_by
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'password' => true,
        'account_number' => true,
        'bank_name' => true,
        'referred_by' => true,
        'user_level' => true,
        'referral_link' => true,
        'reference_number' => true,
        'deposit_image' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
    protected function _setPassword($password){
        return (new DefaultPasswordHasher)->hash($password);
    }    
}
