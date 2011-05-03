<?php

/**
 * Base project form.
 * 
 * @package    router
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class CFProfileUpdateForm extends sfFormSymfony
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormInputText(),
      'name_en'        => new sfWidgetFormInputText(),
      'is_def_allowed' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorString(),
      'name_en'        => new sfValidatorRegex(array(
          'pattern' => '/^[a-z-]*$/'
      )),
      'is_def_allowed' => new sfValidatorBoolean()
    ));

    $this->getWidgetSchema()->setNameFormat('form[%s]');
  }

}
