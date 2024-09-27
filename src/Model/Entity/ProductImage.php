<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductImage Entity
 *
 * @property int $id
 * @property int|null $image_id
 * @property int|null $product_id
 * @property int|null $status
 *
 * @property \App\Model\Entity\Image $image
 * @property \App\Model\Entity\Product $product
 */
class ProductImage extends Entity
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
        'image_id' => true,
        'product_id' => true,
        'status' => true,
        'image' => true,
        'product' => true
    ];
}
