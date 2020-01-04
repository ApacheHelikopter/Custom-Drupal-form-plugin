<?php

namespace Drupal\waffle_icecream_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\State\StateInterface;
use Drupal\waffle_icecream_form\OrderState;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * IceWaffle custom form.
 *
 * @Block(
 *  id = "icewaffle_block",
 *  admin_label = @Translation("IceWaffle"),
 * )
 */
class IceWaffleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  
   public function build() {
    
    $form = \Drupal::formBuilder()->getForm('Drupal\waffle_icecream_form\Form\IceWaffleForm');
    return $form;

  }


}