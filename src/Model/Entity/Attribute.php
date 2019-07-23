<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attribute Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $parent_id
 * @property int|null $status
 *
 * @property \App\Model\Entity\ParentAttribute $parent_attribute
 * @property \App\Model\Entity\ChildAttribute[] $child_attributes
 * @property \App\Model\Entity\ProductAttribute[] $product_attributes
 */
class Attribute extends Entity
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
        'parent_id' => true,
        'status' => true,
        'parent_attribute' => true,
        'child_attributes' => true,
        'product_attributes' => true
    ];
}
