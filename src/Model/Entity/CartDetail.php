<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CartDetail Entity
 *
 * @property int $id
 * @property int|null $cart_id
 * @property int|null $product_id
 * @property string|null $name
 * @property int|null $price
 * @property int|null $quantity
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Cart $cart
 * @property \App\Model\Entity\Product $product
 */
class CartDetail extends Entity
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
        'cart_id' => true,
        'product_id' => true,
        'name' => true,
        'price' => true,
        'quantity' => true,
        'created' => true,
        'modified' => true,
        'cart' => true,
        'product' => true
    ];
}
