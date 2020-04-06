<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserPackage Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $package_id
 * @property string|null $activation_code
 * @property int|null $is_used
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Package $package
 */
class UserPackage extends Entity
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
        'user_id' => true,
        'package_id' => true,
        'activation_code' => true,
        'is_used' => true,
        'user' => true,
        'package' => true,
    ];
}
