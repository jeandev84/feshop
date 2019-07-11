<?php
namespace app\controllers\admin;


use app\models\AppModel;
use app\models\User;
use Framework\Routing\Controller;


/**
 * Class AppController
 *
 * @package app\controllers\admin
 */
class AppController extends Controller
{

    /**
     * @var string $layout
     */
    public $layout = 'admin';


    /**
     * AppController constructor.
     *
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);

        // Middleware [ FaceControl to access Admin ]
        if(!User::isAdmin() && $route['action'] != 'login-admin')
        {
            redirect(ADMIN . '/user/login-admin'); // UserController::loginAdminAction
        }

        // Get connection
        new AppModel();

    }


    /**
     * Helper method
     */
    public function getRequestID($get = true, $id = 'id')
    {
        if($get)
        {
            $data = $_GET;
        }else{
            $data = $_POST;
        }
        $id = !empty($data[$id]) ? (int)$data[$id] : null;

        if(!$id)
        {
            throw new \Exception('Страница не найдена', 404);
        }
        return $id;
    }
}