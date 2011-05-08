<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>

    <div id="page">
      <div id="header"></div>

      <div class="">
        <div id="navigation">
<?php include_partial('global/menu', array(
  'class' => 'menu',
  'items' => array(
    array(
      'route' => '@identities',
      'title' => 'Учетные записи',
      'items' => array(
        array(
          'route' => '@add_identity',
          'title' => 'Создание новой'
        )
      )
    ),
    array(
      'route' => '@cf',
      'title' => 'Контент-фильтр'
    )
  )
)) ?> 
        </div>
        <div id="content">
          <div id="content-header" style="margin-bottom:2em;">
<?php include_slot('content-header') ?>

          </div>
          <div id="content-body">
<?php echo $sf_content ?>

          </div>
        </div>
      </div>

    </div>

  </body>
</html>
