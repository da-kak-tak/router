
<?php include_partial('header', array(
  'profile' => $profile,
)) ?>

<form
  action="<?php echo url_for('@cf_profile_update?id='.$profile->getNameEn()) ?>"
  method="post"
>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form->renderHiddenFields() ?>

<?php $field = $form['name'] ?>
<dl class="form-row">
  <dt>Название</dt>
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
  <button type="submit">Внести изменения</button>
</div>

</form>