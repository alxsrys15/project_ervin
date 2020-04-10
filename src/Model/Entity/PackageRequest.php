<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PackageRequest Entity
 *
 * @property int $id
 * @property int|null $package_id
 * @property int|null $user_id
 * @property string|null $bank_reference
 * @property string|null $status
 * @property int|null $qty
 *
 * @property \App\Model\Entity\Package $package
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\UserPackage $user_package
 */
class PackageRequest extends Entity
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
        'package_id' => true,
        'user_id' => true,
        'bank_reference' => true,
        'status' => true,
        'qty' => true,
        'package' => true,
        'user' => true,
        'user_package' => true,
    ];
}
