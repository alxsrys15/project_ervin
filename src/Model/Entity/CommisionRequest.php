<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CommisionRequest Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate|null $date_start
 * @property \Cake\I18n\FrozenDate|null $date_end
 * @property float|null $amount
 * @property int|null $user_id
 * @property string|null $status
 *
 * @property \App\Model\Entity\User $user
 */
class CommisionRequest extends Entity
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
        'date_start' => true,
        'date_end' => true,
        'amount' => true,
        'user_id' => true,
        'status' => true,
        'user' => true,
    ];
}
