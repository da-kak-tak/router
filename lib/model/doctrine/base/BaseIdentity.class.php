<?php

/**
 * BaseIdentity
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $is_enabled
 * @property boolean $is_inet_allowed
 * @property integer $inet_channels_id
 * @property integer $auth_type
 * @property InetChannel $InetChannel
 * 
 * @method integer     getId()               Returns the current record's "id" value
 * @method string      getName()             Returns the current record's "name" value
 * @method string      getDescription()      Returns the current record's "description" value
 * @method boolean     getIsEnabled()        Returns the current record's "is_enabled" value
 * @method boolean     getIsInetAllowed()    Returns the current record's "is_inet_allowed" value
 * @method integer     getInetChannelsId()   Returns the current record's "inet_channels_id" value
 * @method integer     getAuthType()         Returns the current record's "auth_type" value
 * @method InetChannel getInetChannel()      Returns the current record's "InetChannel" value
 * @method Identity    setId()               Sets the current record's "id" value
 * @method Identity    setName()             Sets the current record's "name" value
 * @method Identity    setDescription()      Sets the current record's "description" value
 * @method Identity    setIsEnabled()        Sets the current record's "is_enabled" value
 * @method Identity    setIsInetAllowed()    Sets the current record's "is_inet_allowed" value
 * @method Identity    setInetChannelsId()   Sets the current record's "inet_channels_id" value
 * @method Identity    setAuthType()         Sets the current record's "auth_type" value
 * @method Identity    setInetChannel()      Sets the current record's "InetChannel" value
 * 
 * @package    router
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIdentity extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('public.identities');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('is_enabled', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('is_inet_allowed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('inet_channels_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('auth_type', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('InetChannel', array(
             'local' => 'inet_channels_id',
             'foreign' => 'id'));
    }
}