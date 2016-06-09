<?php

namespace Kantaria\Models;

use Kantaria\Models\Base\User as BaseUser;

 /**
 * @SWG\Definition(definition="user", required={"username", "password"})
 * @SWG\Property(
 *   property="username",
 *   type="string",
 *   description="The unqiue username for the user" 
 * )
 */
class User extends BaseUser
{

}
