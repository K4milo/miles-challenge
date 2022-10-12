<?php

namespace Drupal\user_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;

/**
 * Provides a block with user info.
 *
 * @Block(
 *   id = "customer_info",
 *   label = @Translation("Customized block with user info"),
 *   module = "user",
 *   context = {
 *     "current_user" = @ContextDefinition("entity:user", label = @Translation("Current User"))
 *   }
 * )*/
class UserBlockInfo extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user_info = '';
    global $base_url;

    try {
      // Get the context value. If the context is not found, ContextException.
      /**@var \Drupal\user\Entity\User $user */
      $user = User::load(\Drupal::currentUser()->id());
      $lastLoginTime = date('d/m/Y H:i:s', $user->getLastLoginTime());
      $user_info .= '<div>' . $user->contextData . $lastLoginTime . '</div>';
    }
    catch (ContextException $e) {
      echo $e->getMessage();
    }
    return [
      '#markup' => $user_info,
      '#cache' => [
        'context' => ['url'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

}
