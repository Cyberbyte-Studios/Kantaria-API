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
 * @SWG\Property(
 *   property="password",
 *   type="string",
 *   description="The users passsword" 
 * )
 * 
 * @SWG\Parameter(name="username", in="body", type="string", required=true, description="protected item name", maxLength=126)
 */
class User extends BaseUser
{

}
