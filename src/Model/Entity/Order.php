<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property int|null $phone
 * @property string|null $address
 * @property string|null $email
 * @property int|null $total
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class Order extends Entity
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
        'name' => true,
        'phone' => true,
        'address' => true,
        'email' => true,
        'total' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'order_details' => true
    ];
}
