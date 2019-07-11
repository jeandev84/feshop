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
	
	
	/**
     * Action index
     *
     * @return void
     */
    public function indexAction()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 3;
        $count = R::count('user');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();
        $users = R::findAll('user', "LIMIT $start, $perpage");

        $this->setMeta('Список пользователей');
        $this->set(compact('users', 'pagination', 'count'));
    }


    /**
     * Action Add [ User ]
     *
     * @return void
     */
    public function addAction()
    {
        $this->setMeta('Новый пользователь');
    }


    /**
     * Action Edit
     *
     *
     * @throws \Exception
     */
    public function editAction()
    {
        if(!empty($_POST))
        {

            $id = $this->getRequestID(false);
            $user = new \app\models\admin\User();
            $data = $_POST;
            $user->load($data);

            // если аттрибут пусть значить пользователь не менял пароль
            if(!$user->attributes['password'])
            {
                // удаляем из аттрибутов это самого пароля
                unset($user->attributes['password']);

            }else{// а если не пусть значить он поменял пароль и нам надо захэшировать пароля

                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            }

            // validation
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();
                redirect();
            }
            if($user->update('user', $id))
            {
                $_SESSION['success'] = 'Изменения сохранены';
            }
            redirect();
        }

        $user_id = $this->getRequestID();
        $user = R::load('user', $user_id);

        $orders = R::getAll(
		"SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, 
		        `order`.`date`, `order`.`update_at`, `order`.`currency`, 
		 ROUND(SUM(`order_product`.`price`), 2) AS `sum` 
		 FROM `order`
         JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
         WHERE user_id = {$user_id} 
		 GROUP BY `order`.`id` 
		 ORDER BY `order`.`status`, `order`.`id`");

        $this->setMeta('Редактирование профиля пользователя');
        $this->set(compact('user', 'orders'));
    }


}