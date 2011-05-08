
<?php include_partial('global/content-header', array(
  'navigation' => array(
    array(
      'route' => '@cf',
      'title' => 'Профили фильтрации'
    )
  ),
  'title' => 'Новый профиль'
)) ?>

<form
  action="<?php echo url_for('@add_cf_profile') ?>"
  method="post"
>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form->renderHiddenFields() ?>

<?php $field = $form['name'] ?>
<dl class="form-row">
  <dt>Имя профиля</dt>
  <dd>
<?php echo $field->render(array('style' => 'width:100%;')) ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['name_en'] ?>
<dl class="form-row">
  <dt>Английское название</dt>
  <dd>
<?php echo $field->render() ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>


<?php $field = $form['is_def_allowed'] ?>
<dl class="form-row">
  <dt></dt>
  <dd>
<?php echo $field->render() ?>&nbsp;<label for="form_is_def_allowed" style="font-size:90%;">По умолчанию все разрешать</label>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<div class="submit">
  <button type="submit">Создать профиль</button>
</div>

</form>