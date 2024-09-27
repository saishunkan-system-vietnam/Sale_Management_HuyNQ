<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property int|null $price
 * @property int|null $quantity
 * @property string|null $description
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $category_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\CartDetail[] $cart_details
 * @property \App\Model\Entity\Image[] $images
 * @property \App\Model\Entity\OrderDetail[] $order_details
 * @property \App\Model\Entity\ProductAttribute[] $product_attributes
 */
class Product extends Entity
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
        'price' => true,
        'quantity' => true,
        'description' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'category_id' => true,
        'user' => true,
        'category' => true,
        'cart_details' => true,
        'images' => true,
        'order_details' => true,
        'product_attributes' => true
    ];
}
