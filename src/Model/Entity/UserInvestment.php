<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserInvestment Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int|null $amount
 * @property int|null $user_id
 * @property int|null $is_active
 * @property string|null $reference_number
 * @property \Cake\I18n\FrozenDate|null $date_approved
 *
 * @property \App\Model\Entity\User $user
 */
class UserInvestment extends Entity
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
        'date' => true,
        'amount' => true,
        'user_id' => true,
        'is_active' => true,
        'reference_number' => true,
        'date_approved' => true,
        'user' => true,
    ];
}
