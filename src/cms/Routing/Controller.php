<?php
namespace Framework\Routing;



use Framework\Template\View;


/**
 * Class Controller
 *
 * @package Framework\Routing
 */
abstract class Controller
{
    /**
     * @var array  $route
     * @var string $controller
     * @var string $model
     * @var string $view
     * @var string $prefix
     * @var array  $data
     * @var array  $meta
     * @var string $layout
     */
    protected $route = [];
    protected $controller;
    protected $model;
    protected $view;
    protected $prefix;
    protected $data = [];
    protected $meta = ['title' => '', 'desc'  => '', 'keywords' => ''];
    protected $layout;


    /**
     * Controller Constructor.
     *
     * @param array $route
     * @return void
     */
    public  function __construct($route)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }


    /**
     * Get view
     *
     * @return void
     * @throws \Exception
     */
    public function getView()
    {
         $viewObj = new View($this->route, $this->layout, $this->view, $this->meta);
         $viewObj->render($this->data);
    }


    /**
     * Set data for parsing to view
     *
     *
     * @param array $data
     */
    protected function set($data)
    {
        $this->data = $data;
    }


    /**
     * Set meta data
     *
     *
     * @param string $title
     * @param string $desc
     * @param string $keywords
     */
    protected function setMeta($title='', $desc = '', $keywords = '')
    {
        $this->meta = compact('title', 'desc', 'keywords');
    }



   
}