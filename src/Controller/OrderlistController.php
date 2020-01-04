<?php

namespace Drupal\waffle_icecream_form\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\State\StateInterface;
use Drupal\waffle_icecream_form\OrderState;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrderListController extends ControllerBase {

protected $orderState;
protected $state;

    public function __construct(StateInterface $state, OrderState $orderState) {
        $this->state = $state;
        $this->orderState = $orderState;
    }

    public static function create(ContainerInterface $container) {
        return new static(
        $container->get('state'),
        $container->get('waffle_icecream_form.order_state')
        );
    }

    public function buildOrderlist() {
        return [
            '#theme' => 'icewaffle',
            '#attached' => ['library' => ['waffle_icecream_form/icewaffle_media']],
            '#icecream_orders' => $this->orderState->getOrders('Icecream'),
            '#waffle_orders' => $this->orderState->getOrders('Waffle'),
          ];
    }
  
}
