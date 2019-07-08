<?php
namespace Framework\Template;



class View
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
    protected $meta = [];
    protected $layout;


    /**
     * View constructor.
     *
     *
     * @param $route
     * @param string $layout
     * @param string $view
     * @param array $meta
     * @return void
     */
    public  function __construct($route, $layout = '', $view = '', $meta = [])
    {
        $this->route = $route;
        $this->view  = $view;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->prefix = $route['prefix'];
        $this->meta = $meta;

        if($layout === false)
        {
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }
    }


}