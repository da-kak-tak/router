<?php

/**
 * BaseCFRule
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $profile_id
 * @property boolean $is_allowed
 * @property integer $type_id
 * @property string $value
 * @property boolean $is_enabled
 * @property CFProfile $CFProfile
 * @property CFType $CFType
 * 
 * @method integer   getId()         Returns the current record's "id" value
 * @method integer   getProfileId()  Returns the current record's "profile_id" value
 * @method boolean   getIsAllowed()  Returns the current record's "is_allowed" value
 * @method integer   getTypeId()     Returns the current record's "type_id" value
 * @method string    getValue()      Returns the current record's "value" value
 * @method boolean   getIsEnabled()  Returns the current record's "is_enabled" value
 * @method CFProfile getCFProfile()  Returns the current record's "CFProfile" value
 * @method CFType    getCFType()     Returns the current record's "CFType" value
 * @method CFRule    setId()         Sets the current record's "id" value
 * @method CFRule    setProfileId()  Sets the current record's "profile_id" value
 * @method CFRule    setIsAllowed()  Sets the current record's "is_allowed" value
 * @method CFRule    setTypeId()     Sets the current record's "type_id" value
 * @method CFRule    setValue()      Sets the current record's "value" value
 * @method CFRule    setIsEnabled()  Sets the current record's "is_enabled" value
 * @method CFRule    setCFProfile()  Sets the current record's "CFProfile" value
 * @method CFRule    setCFType()     Sets the current record's "CFType" value
 * 
 * @package    router
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCFRule extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('public.cf_rules');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('profile_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('is_allowed', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('type_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('value', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('is_enabled', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CFProfile', array(
             'local' => 'profile_id',
             'foreign' => 'id'));

        $this->hasOne('CFType', array(
             'local' => 'type_id',
             'foreign' => 'id'));
    }
}