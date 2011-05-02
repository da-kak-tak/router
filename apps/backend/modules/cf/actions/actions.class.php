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
    $this->profiles = $q->fetchArray();
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
  public function executeProfileUpdate()
  {
    $this->forward404Unless(
      $this->profile = Doctrine_Core::getTable('CFProfile')->findOneByNameEn( $this->request->getParameter('id') )
      );

    
  }
}
