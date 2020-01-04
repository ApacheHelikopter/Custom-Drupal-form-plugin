<?php

namespace Drupal\waffle_icecream_form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Database\Connection;

class OrderState {
    protected $connection;
    protected $time;

    public function __construct(Connection $connection, TimeInterface $time) {
        $this->connection = $connection;
        $this->time = $time;
    }

    public function addOrder(string $lastName, string $firstName, string $iceWaffle, string $iceFlavour, array $waffleTopping){
        $this->connection->insert('waffle_icecream_form_orderstate')
          ->fields([
            'last_name' => $lastName,
            'first_name' => $firstName,
            'ice_waffle' => $iceWaffle,
            'ice_flavour' => $iceFlavour,
            'waffle_topping_1' => $waffleTopping['Nutella'],
            'waffle_topping_2' => $waffleTopping['Butter'],
            'waffle_topping_3' => $waffleTopping['Brown Sugar'],
            'waffle_topping_4' => $waffleTopping['Fruits'],
            'time_clicked' => $this->time->getRequestTime(),
            
          ])->execute()
        ;
    }

    public function getOrders(string $iceWaffle){
      $query = $this->connection->select('waffle_icecream_form_orderstate', 'w');
      $query->condition('w.ice_waffle', $iceWaffle);
      return (int) $query->countQuery()->execute()->fetchField();
    }

    public function getAllOrders(){
      $query = $this->connection->select('waffle_icecream_form_orderstate', 'w');
      $query->fields('w', ['first_name','ice_waffle']);
      return $query->execute()->fetchAssoc();
    }
}