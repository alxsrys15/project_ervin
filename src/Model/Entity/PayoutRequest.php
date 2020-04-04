<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PayoutRequest Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $start_date
 * @property \Cake\I18n\FrozenTime|null $end_date
 * @property int|null $captcha_count
 * @property int|null $referral_count
 * @property int|null $total
 * @property int|null $user_id
 * @property string|null $status
 *
 * @property \App\Model\Entity\User $user
 */
class PayoutRequest extends Entity
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
        'start_date' => true,
        'end_date' => true,
        'captcha_count' => true,
        'referral_count' => true,
        'total' => true,
        'user_id' => true,
        'status' => true,
        'user' => true,
    ];
}
