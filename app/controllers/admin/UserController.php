<?php
namespace app\controllers\admin;

use app\models\User;
use Framework\Library\Pagination;
use R;



/**
 * Class UserController
 *
 * @package app\controllers\admin
 */
class UserController extends AppController
{

    /**
     * URL: /user/login-admin
     * Action loginAdmin
     */
    public function loginAdminAction()
    {
        if(!empty($_POST))
        {
            $user = new User();

            // if admin login
            if(!$user->login(true))
            {
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }

            if(User::isAdmin())
            {
                redirect(ADMIN);

            }else{

                redirect();
            }
        }
        $this->layout = 'login';
    }

}