<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Package Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $qty
 * @property int|null $price
 * @property int|null $is_active
 *
 * @property \App\Model\Entity\User[] $users
 */
class Package extends Entity
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
        'name' => true,
        'qty' => true,
        'price' => true,
        'is_active' => true,
        'users' => true,
    ];
}
