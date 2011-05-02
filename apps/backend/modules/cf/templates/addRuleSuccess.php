
<?php include_partial('header', array(
  'profile' => $profile,
)) ?>

<div class="extended">
<form
  action="<?php echo url_for('@cf_profile_add_rule?id='.$profile->getNameEn()) ?>"
  method="post"
>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form['value']->renderError() ?>

<?php echo $form->renderHiddenFields() ?>

<div class="" style="margin-top:.75em;">
  <?php echo $form['is_allowed']->render() ?>
  &nbsp;
  <?php echo $form['type_id']->render() ?>
  <?php echo $form['value']->render(array('style' => 'width:18em; font-size:110%;')) ?>

  <span
    style="
      margin-left:1em;
      padding:.35em .5em .5em .5em;
      -webkit-border-radius:1em;
      background:#e6f3ff;
    "
  >
    <button type="submit">Добавить</button>
  </span>
</div>

</form>
</div>