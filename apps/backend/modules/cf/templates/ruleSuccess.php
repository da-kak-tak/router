
<?php include_partial('header', array(
  'profile' => $profile,
)) ?>

<div class="extended">
<form
  action="<?php echo url_for('@cf_rule?profile='.$profile->getNameEn().'&rule='.$rule->getId()) ?>"
  method="post"
>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form['value']->renderError() ?>

<?php echo $form->renderHiddenFields() ?>

<div class="" style="margin-top:.75em;">
  <?php echo $form['is_enabled']->render() ?>
  <label for="form_is_enabled">Акт.</label>
  &nbsp;&nbsp;
  <?php echo $form['is_allowed']->render() ?>
  &nbsp;
  <?php echo $form['type_id']->render() ?>
  <?php echo $form['value']->render(array('style' => 'width:18em; font-size:110%;')) ?>

  <span
    style="
      margin-left:1em;
    "
  >
    <button type="submit">Изменить</button>
  </span>
</div>

</form>
</div>