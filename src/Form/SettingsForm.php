<?php

namespace Drupal\waffle_icecream_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SettingsForm extends FormBase {

  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state')
    );
  }

  public function getFormId() {
    return 'icewaffle_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['max_amount_icecream'] = [
      '#type' => 'textfield',
      '#title' => 'Maximum icecream orders',
      '#default_value' => $this->state->get('waffle_icecream_form.max_amount_icecream'),
    ];
    $form['max_amount_waffle'] = [
      '#type' => 'textfield',
      '#title' => 'Maximum waffle orders',
      '#default_value' => $this->state->get('waffle_icecream_form.max_amount_waffle'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save',
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->state->set('waffle_icecream_form.max_amount_icecream', $form_state->getValue('max_amount_icecream'));
    $this->state->set('waffle_icecream_form.max_amount_waffle', $form_state->getValue('max_amount_waffle'));
    drupal_set_message('Saved settings');
  }

}
