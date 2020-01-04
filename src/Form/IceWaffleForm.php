<?php

namespace Drupal\waffle_icecream_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\State\StateInterface;
use Drupal\waffle_icecream_form\OrderState;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * IceWaffle custom form.
 */

class IceWaffleForm extends FormBase {

  protected $state;
  protected $orderState;

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
  
  public function getFormId(){
    return 'icewaffle_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
    ];

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
    ];

    $form['choice_icewaffle'] = [
      '#type' => 'select',
      '#title' => $this->t('Make your choice'),
      '#default_value' => 'Icecream',
      '#options' => [
        'Icecream' => $this->t('Icecream'),
        'Waffle' => $this->t('Waffle'),
      ],
      '#required' => TRUE,
    ];

    $form['flavour_icecream'] = [
      '#type' => 'radios',
      '#title' => $this->t('Choose your flavour'),
      '#default_value' => 0,
      '#options' => [
        'Vanilla' => $this->t('Vanilla'),
        'Chocolate' => $this->t('Chocolate'),
        'Pistachio' => $this->t('Pistachio'),
        'Strawberry' => $this->t('Strawberry'),
        'Cookie Dough' => $this->t('Cookie Dough'),
      ],
      '#states' => [
        'visible' => [
          'select[name="choice_icewaffle"' => [
            'value' => 'Icecream',
          ],
        ],
      ],
    ];

    $form['topping_waffle'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Choose your topping(s)'),
      '#options' => [
        'Nutella' => $this->t('Nutella'),
        'Butter' => $this->t('Butter'),
        'Brown Sugar' => $this->t('Brown Sugar'),
        'Fruits' => $this->t('Fruits'),
      ],
      '#tree' => TRUE,
      '#states' => [
        'visible' => [
          'select[name="choice_icewaffle"' => [
            'value' => 'Waffle',
          ],
        ],
      ],
    ];


    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit')
    ];

    return $form;
    
  }

  public function submitForm(array &$form, FormStateInterface $form_state){
    $values = $form_state->getValues();
    
    $lastName = $values['last_name'];
    $firstName = $values['first_name'];
    $iceWaffle = $values['choice_icewaffle'];
    $flavourIcecream = $values['flavour_icecream'];
    $waffleToppings = $values['topping_waffle'];
    


    if($iceWaffle == 'Waffle'){
      $this->orderState->addOrder($lastName, $firstName, $iceWaffle, $flavourIcecream, $waffleToppings);

      $max_amount_waffle = $this->state->get('waffle_icecream_form.max_amount_waffle');
      $ordered_amount_waffle = $this->state->get('waffle_icecream_form.ordered_amount_waffle');
      if($ordered_amount_waffle < $max_amount_waffle){

        $ordered_amount_waffle = $this->state->get('waffle_icecream_form.ordered_amount_waffle') + 1;

        if($ordered_amount_waffle == $max_amount_waffle){
          $ordered_amount_waffle = 0;
          $this->state->set('waffle_icecream_form.ordered_amount_waffle', $ordered_amount_waffle);
          drupal_set_message("Maximum amount of waffle orders is reached", 'warning');
        }
        else{
          $this->state->set('waffle_icecream_form.ordered_amount_waffle', $ordered_amount_waffle);
          drupal_set_message('Thank you ' . $firstName . '!');
          drupal_set_message('There are currently ' . $ordered_amount_waffle . ' out of ' . $max_amount_waffle . ' waffle orders');
        }
      }
      else{
        $this->state->set('waffle_icecream_form.ordered_amount_waffle', 0);
      }
    }
    else{
      $this->orderState->addOrder($lastName, $firstName, $iceWaffle, $flavourIcecream, $waffleToppings);

      $max_amount_icecream = $this->state->get('waffle_icecream_form.max_amount_icecream');
      $ordered_amount_icecream = $this->state->get('waffle_icecream_form.ordered_amount_icecream');

      if($ordered_amount_icecream < $max_amount_icecream){

        $ordered_amount_icecream = $this->state->get('waffle_icecream_form.ordered_amount_icecream') + 1;

        if($ordered_amount_icecream == $max_amount_icecream){
          $ordered_amount_icecream = 0;
          $this->state->set('waffle_icecream_form.ordered_amount_icecream', $ordered_amount_icecream);
          drupal_set_message("Maximum amount of icecream orders is reached", 'warning');
        }
        else{
          $this->state->set('waffle_icecream_form.ordered_amount_icecream', $ordered_amount_icecream);
          drupal_set_message('Thank you ' . $firstName . '!');
          drupal_set_message('There are currently ' . $ordered_amount_icecream . ' out of ' . $max_amount_icecream . ' icecream orders');
        }
      } else{
        $this->state->set('waffle_icecream_form.ordered_amount_icecream', 0);
      }
      
    }
    
    


    
    
    
    
    //$this->orderState->addOrder($lastName, $firstName, $iceWaffle, $flavourIcecream, $check);
    //drupal_set_message($form_state['values']['topping_waffle']);
    /**$this->orderState->addOrder(
    $form_state->getValue('last_name'),
    $form_state->getValue('first_name'),
    $form_state->cleanValues()->getValue('choice_icewaffle'),
    $form_state->cleanValues()->getValue('flavour_icecream'),
    $form_state->cleanValues()->getValues('topping_waffle')
    );
    **/
  }

}