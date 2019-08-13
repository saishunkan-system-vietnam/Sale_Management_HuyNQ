<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sale Entity
 *
 * @property int $id
 * @property int|null $value
 * @property int $product_id
 * @property \Cake\I18n\FrozenTime|null $startday
 * @property \Cake\I18n\FrozenTime|null $endday
 * @property int|null $status
 *
 * @property \App\Model\Entity\Product $product
 */
class Sale extends Entity
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
        'value' => true,
        'product_id' => true,
        'startday' => true,
        'endday' => true,
        'status' => true,
        'product' => true
    ];
}
