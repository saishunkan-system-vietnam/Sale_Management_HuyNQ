<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductAttribute Entity
 *
 * @property int $id
 * @property int|null $attribute_id
 * @property int|null $product_id
 * @property string|null $value
 *
 * @property \App\Model\Entity\Attribute $attribute
 * @property \App\Model\Entity\Product $product
 */
class ProductAttribute extends Entity
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
        'attribute_id' => true,
        'product_id' => true,
        'value' => true,
        'attribute' => true,
        'product' => true
    ];
}
