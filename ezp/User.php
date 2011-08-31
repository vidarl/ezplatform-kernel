<?php
/**
 * File containing User object
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace ezp;
use ezp\Base\Model,
    ezp\Base\Collection\Type as TypeCollection,
    ezp\Persistence\User as UserValue,
    ezp\User\LocatableInterface,
    ezp\User\GroupLocation;

/**
 * This class represents a User item
 *
 * @property-read mixed $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property int $hashAlgorithm
 * @property \ezp\User\Role[] $roles
 * @property \ezp\User\Policy[] $policies
 */
class User extends Model implements LocatableInterface
{
    /**
     * @var array Readable of properties on this object
     */
    protected $readWriteProperties = array(
        'id' => false,
        'login' => true,
        'email' => true,
        'password' => true,
        'hashAlgorithm' => true,
    );

    /**
     * @var array Dynamic properties on this object
     */
    protected $dynamicProperties = array(
        //'groups' => false,
        'roles' => false,
        'policies' => false,
    );

    /**
     * @var \ezp\Content The User Group Content Object
     */
    protected $content;

    /**
     * Assigned Roles
     *
     * @var \ezp\User\Role[]
     */
    protected $roles = array();

    /**
     * Assigned and inherited policies (via assigned and inherited roles)
     *
     * @var \ezp\User\Policy[]
     */
    protected $policies = array();

    /**
     * @var \ezp\User\GroupLocation[] The User Group locations
     */
    protected $locations;

    /**
     * Creates and setups User object
     *
     * @param mixed $id Lets you specify id of User object on creation
     */
    public function __construct( $id = null )
    {
        $this->properties = new UserValue( array( 'id' => $id ) );
        $this->content = (object) array( 'locations' => array() );
    }

    /**
     * @return \ezp\User\GroupLocation[]
     */
    public function getLocations()
    {
        if ( $this->locations !== null )
            return $this->locations;

        $this->locations = array();
        foreach ( $this->content->locations as $contentLocation )
            $this->locations[] = new GroupLocation( $contentLocation, $this );

        return $this->locations;
    }

    /**
     * List of assigned Roles
     *
     * @return array|User\Role[]
     */
    protected function getRoles()
    {
        return $this->roles;
    }

    /**
     * List of assigned and inherited policies (via assigned and inherited roles)
     *
     * @return array|User\Policy[]
     */
    protected function getPolicies()
    {
        return $this->policies;
    }
}
