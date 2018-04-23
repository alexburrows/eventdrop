<?php

namespace Drupal\eventdrop_fee;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\OrderProcessorInterface;
use Drupal\commerce_price\Price;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_order\Adjustment;

/**
 * Adds handling fee to all orders.
 *
 * @package Drupal\eventdrop_fee
 */
class EventdropFee implements OrderProcessorInterface {
  /**
   * {@inheritdoc}
   */
  public function process(OrderInterface $order)  {
    foreach ($order->getItems() as $order_item) {
      $order_item->setAdjustments([]);
      // Apply custom adjustment.
      $adjustments[] = new Adjustment([
        'type' => 'eventdrop_fee',
        'label' => 'Eventdrop Fee',
        'amount' => new Price('0.50', 'GBP'),
      ]);
      $order_item->setAdjustments($adjustments);
      $order_item->save();
    }
  }
}