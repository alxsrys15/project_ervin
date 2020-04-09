<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CaptchaPayout Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate|null $date_start
 * @property \Cake\I18n\FrozenDate|null $date_end
 * @property int|null $self_count
 * @property int|null $first_level_count
 * @property int|null $second_level_count
 * @property int|null $third_level_count
 * @property int|null $total
 * @property string|null $status
 * @property int|null $user_id
 */
class CaptchaPayout extends Entity
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
        'self_count' => true,
        'first_level_count' => true,
        'second_level_count' => true,
        'third_level_count' => true,
        'total' => true,
        'status' => true,
        'user_id' => true,
    ];
}
