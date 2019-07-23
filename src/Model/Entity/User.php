<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $username
 * @property string|null $password
 * @property string|null $name
 * @property int|null $phone
 * @property string|null $address
 * @property int|null $type
 * @property string|null $notice
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Product[] $products
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
        'email' => true,
        'username' => true,
        'password' => true,
        'name' => true,
        'phone' => true,
        'address' => true,
        'type' => true,
        'notice' => true,
        'created' => true,
        'modified' => true,
        'carts' => true,
        'orders' => true,
        'products' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
