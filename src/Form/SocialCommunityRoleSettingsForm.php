<?php

namespace Drupal\social_community_role\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\Role;

/**
 * Class SocialCommunityRoleSettingsForm.
 */
class SocialCommunityRoleSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'social_community_role_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $social_community_role_config = $this->configFactory->getEditable('social_community_role.settings');

    // Add an introduction text to explain what can be done here.
    $form['introduction']['warning'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('Be aware that you need to assign a role in order to make it work.'),
    ];

    $roles = Role::loadMultiple();
    $existing_roles = [];
    foreach($roles as $key => $role) {
      $existing_roles[$key] = $role->label();
    }

    

    if (isset($existing_roles) && !empty($existing_roles)) {

      $form['role'] = [
        '#type' => 'select',
        '#title' => $this->t('Select role'),
        '#description' => $this->t('Select the role.'),
        '#options' => $existing_roles,
        '#default_value' => $social_community_role_config->get('role'),
      ];
    

      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#button_type' => 'primary',
        '#button_level' => 'raised',
        '#value' => $this->t('Save configuration'),
      ];

    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('social_community_role.settings');
    $config->set('role', $form_state->getValue('role'));
    $config->save();
  }

  /**
   * Gets the configuration names that will be editable.
   */
  protected function getEditableConfigNames() {
    // @todo Implement getEditableConfigNames() method.
  }

}
