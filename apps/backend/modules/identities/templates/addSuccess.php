
<?php include_partial('global/content-header', array(
  'navigation' => array(
    array(
      'route' => '@identities',
      'title' => 'Учетки'
    )
  ),
  'title' => 'Новая учетная запись'
)) ?>


<form
  action="<?php echo url_for('@add_identity') ?>"
  method="post"
>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form->renderHiddenFields() ?>

<?php $field = $form['name'] ?>
<dl class="form-row">
  <dt>Имя учетной записи</dt>
  <dd>
<?php echo $field->render() ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['description'] ?>
<dl class="form-row">
  <dt>Описание</dt>
  <dd>
<?php echo $field->render(array('style' => 'width:100%')) ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['type'] ?>
<dl class="form-row">
  <dt>Авторизации</dt>
  <dd>
<?php echo $field->render() ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<div class="submit">
  <button type="submit">Создать</button>
</div>

</form>