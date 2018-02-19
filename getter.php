<?php

/**
 * Trait HasDynamicProperties
 *
 * Allows a class that uses this trait to assign and retrieve properties dynamically.
 */
trait HasDynamicProperties
{
    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);

        if($action === 'get') {
            $propertyName = lcfirst(substr($name, 3));

            if(isset($this->$propertyName)) {
                return $this->$propertyName;
            } else {
                /**
                 * As per the specification, the application throws an exception when the property
                 * we are trying to get the value of does not exist.
                 */
                return new Exception('Property ' . $propertyName . ' does not exist on this object.');
            }
        }

        if($action === 'set') {
            /**
             * In cases where we are setting a property, these is no need to check
             * whether the value exists or not as we can dynamically create it.
             *
             * Despite the specification asking to throw an exception, we can make this
             * trait more user friendly if we just go ahead and create it if it doesn't exist.
             *
             * If we really wished to, we could throw a notice.
             */
            $propertyName = lcfirst(substr($name, 3));
            $this->$propertyName = $arguments[0];
            return null;
        }

        return new Exception('Method ' . $name . ' does not exist.');
    }
}

/**
 * Class Model
 */
class Model
{
    use HasDynamicProperties;
}

/**
 * Class User
 *
 * A user class, which represents a user in our application.
 */
class User extends Model
{
    protected $isLoggedIn = false;

    public function login()
    {
        $this->setLastLoggedInAt(strtotime('now'));
        $this->setIsLoggedIn(true);
        return;
    }

    public function logout()
    {
        $this->setIsLoggedIn(false);
        return;
    }
}

/**
 * Application
 *
 * This tiny snippet will utilise a user model that uses the HasDynamicProperties trait.
 * Using this trait will allow properties to be dynamically 'setted' or 'getted'.
 *
 * In this example, we have our user, Joe, who is currently not logged in. We show a working example
 * of the 'getter' magic method by checking if the user is logged in. This data would not normally be
 * accessible due to it's protected visibility.
 *
 * We then show a working example of our 'setter', which sets the logged in date of our user. This is demonstrated
 * within the login method on the User class.
 */

$joe = new User();

/**
 * Joes status before logging in:
 */
var_dump($joe->getIsLoggedIn());
var_dump($joe->getLastLoggedInAt());

if(!$joe->getIsLoggedIn()) {
    $joe->login();
} else {
    $joe->logout();
}

/**
 * Joes status after logging in:
 */
var_dump($joe->getIsLoggedIn());
var_dump($joe->getLastLoggedInAt());