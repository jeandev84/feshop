<?php
namespace app\controllers;


use app\models\User;

/**
 * Class UserController
 *
 * @package app\controllers
 */
class UserController extends AppController
{

    /**
     * Action signup
     *
     * @return void
     */
    public function signupAction()
    {
        if(!empty($_POST))
        {
            // new instance of user
            $user = new User();

            // storage data $_POST in variable $data
            $data = $_POST;

            // assign user attributes from data $_POST
            $user->load($data);

            // debug($user);

            // if is not valide data
            if(!$user->validate($data))
            {
                 // get errors and saved in errors
                $user->getErrors();
                $_SESSION['form_data'] = $data;

            }else{
                $_SESSION['success'] = 'OK';
            }
            redirect();
        }

        $this->setMeta('Регистрация');
    }


    /**
     * Action login
     *
     * @return void
     */
    public function loginAction()
    {

    }


    /**
     * Action logout
     *
     * @return void
     */
    public function logoutAction()
    {

    }
}