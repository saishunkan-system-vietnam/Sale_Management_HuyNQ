<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductCategory Entity
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $product_id
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Product $product
 */
class ProductCategory extends Entity
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
        'category_id' => true,
        'product_id' => true,
        'category' => true,
        'product' => true
    ];
}
