<?php

/**
 * cf actions.
 *
 * @package    router
 * @subpackage cf
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cfActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    
  }

  /**
   *
   */
  public function executeProfiles()
  {
    $q = Doctrine_Core::getTable('CFProfile')
      ->createQuery('p')
      ->orderBy('p.name');
    $this->profiles = $q->execute();
  }

  /**
   *
   */
  public function executeAddProfile()
  {
    $this->form = new AddCFProfileForm();

    if ($this->request->isMethod('POST'))
    {
      $this->form->bind( $this->request->getParameter('form') );
      if ($this->form->isValid())
      {
        $profile = new CFProfile();
        $profile->fromArray( $this->form->getValues() );
        $profile->save();

        $this->getUser()->setFlash('notice', '');
        $this->redirect('@cf_profile?id='.$profile->getNameEn());
      }
    }
  }

  /**
   *
   */
  public function executeProfile()
  {
    $this->redirect('@cf_profile_rules?id='.$this->request->getParameter('id'));
  }

  /**
   *
   */
  public function executeRules()
  {
    $this->forward404Unless(
      $this->profile = Doctrine_Core::getTable('CFProfile')->findOneByNameEn( $this->request->getParameter('id') )
      );

    $q = Doctrine_Core::getTable('CFRule')
      ->createQuery('r')
      ->leftJoin('r.CFType t')
      ->where('r.profile_id = ?', $this->profile->getId())
      ->orderBy('r.value');
    $this->rules = $q->fetchArray();

    $this->isAllowedValues = CFRule::getIsAllowedValues();
  }

  /**
   *
   */
  public function executeAddRule()
  {
    $this->forward404Unless(
      $this->profile = Doctrine_Core::getTable('CFProfile')->findOneByNameEn( $this->request->getParameter('id') )
      );

    $this->form = new CFRuleForm( array('profile_id' => $this->profile->getId()) );
    $this->form->setDefault('is_allowed', !$this->profile->getIsDefAllowed());
    $this->form->getValidatorSchema()->setPostValidator(
      new sfValidatorDoctrineUnique(array(
        'model'  => 'CFRule',
        'column' => array('profile_id', 'type_id', 'value')
      ))
    );

    if ($this->request->isMethod('POST'))
    {
      $this->form->bind( $this->request->getParameter('form') );
      if ($this->form->isValid())
      {
        $rule = new CFRule();
        $rule->fromArray( $this->form->getValues() );
        $rule->save();

        $this->getUser()->setFlash('notice', '');
        $this->redirect('@cf_profile_add_rule?id='.$this->profile->getNameEn());
      }
    }
  }

  /**
   *
   */
  public function executeRule()
  {
    $q = Doctrine_Core::getTable('CFRule')
      ->createQuery('r')
      ->leftJoin('r.CFProfile p')
      ->where('r.id = ?', $this->request->getParameter('rule'))
      ->andWhere('p.name_en = ?', $this->request->getParameter('profile'));
    $this->forward404Unless( $q->count() );

    $this->rule = $q->fetchOne();
    $this->profile = $this->rule->getCFProfile();

    $this->form = new CFRuleForm(array('profile_id' => $this->profile->getId()));
    $this->form->setWidget('is_enabled', new sfWidgetFormInputCheckbox());
    $this->form->setValidator('is_enabled', new sfValidatorBoolean());
    $this->form->setDefaults( $this->rule->toArray() );

    if ($this->request->isMethod('POST'))
    {
      $this->form->bind( $this->request->getParameter('form') );
      if ($this->form->isValid())
      {
        $this->rule->fromArray( $this->form->getValues() );
        $this->rule->save();

        $this->getUser()->setFlash('notice', '');
        $this->redirect('@cf_rule?profile='.$this->profile->getNameEn().'&rule='.$this->rule->getId());
      }
    }
  }

  /**
   *
   */
  public function executeProfileUpdate()
  {
    $this->forward404Unless(
      $this->profile = Doctrine_Core::getTable('CFProfile')->findOneByNameEn( $this->request->getParameter('id') )
      );

    $this->form = new CFProfileUpdateForm();
    $this->form->setDefaults( $this->profile->toArray() );

    if ($this->request->isMethod('POST'))
    {
      $this->form->bind( $this->request->getParameter('form') );
      if ($this->form->isValid())
      {
        $this->profile->fromArray( $this->form->getValues() );
        $this->profile->save();

        $this->getUser()->setFlash('notice', '');
        $this->redirect('@cf_profile_update?id='.$this->profile->getNameEn());
      }
    }
  }
}
