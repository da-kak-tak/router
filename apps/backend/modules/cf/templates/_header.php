
<?php $menu = array(
    array(
      'route' => '@cf_profile_add_rule?id='.$profile->getNameEn(),
      'title' => 'Новое правило',
    ),
    array(
      'route' => '@cf_profile_rules?id='.$profile->getNameEn(),
      'title' => 'Правила',
    ),
    array(
      'route' => '@cf_profile_update?id='.$profile->getNameEn(),
      'style' => 'margin-left:1em;',
      'title' => 'Редактировать профиль',
    )
  )
?>

<?php if ($sf_context->getRouting()->getCurrentRouteName() == 'cf_rule'): ?>
  <?php array_push($menu, array(
    'route' => '@cf_rule?profile='.$profile->getNameEn().'&rule='.$sf_params->get('rule'),
    'title' => 'Изменить правило'
  )) ?>
<?php endif; ?>

<?php include_partial('global/content-header', array(
  'navigation' => array(
    array(
      'route' => '@cf',
      'title' => 'Профили фильтрации'
    )
  ),
  'title' => '<span style="margin-left:-1ex;">&laquo;</span>'.$profile->getName().'&raquo;',
  'menu'  => $menu
)) ?>
