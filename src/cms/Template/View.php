<?php
namespace Framework\Template;



use Framework\App;

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


    /**
     * Render
     *
     * @param array $data
     * @throws \Exception
     */
    public function render(array $data = [])
    {

        // extract data
        extract($data);

        // View
        $viewFile = sprintf(APP . '/views/%s%s/%s.php',
            $this->prefix,
            $this->controller,
            $this->view
        );

        $viewFile = $this->normalisePath($viewFile);

        if(is_file($viewFile))
        {
            ob_start();
            require_once($viewFile);
            $content = ob_get_clean();
        }else{
            throw new \Exception(sprintf('Не найден вид [ %s ]', $viewFile));
        }

        // Layout
        if($this->layout !== false)
        {
            $layoutFile = sprintf(APP.'/views/layouts/%s.php', $this->layout);
            $layoutFile = $this->normalisePath($layoutFile);

            if(is_file($layoutFile))
            {
                require_once($layoutFile);
            }else{
                throw new \Exception(sprintf('Не найден шаблон [ %s ]', $layoutFile));
            }
        }
    }


    /**
     * Normalise Path
     *
     * @param $path
     * @return mixed
     */
    protected function normalisePath($path)
    {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
    }



    /*
     * Get meta data
     *
     * @return string
     */
    public function getMeta()
    {
        $html  = '<title>'. $this->meta['title'] . '</title>'. PHP_EOL;
        $html .= '<meta name="description" content="'. $this->meta['desc'] .'">'. PHP_EOL;
        $html .= '<meta name="keywords" content="'. $this->meta['keywords'] .'">'. PHP_EOL;
        return $html;
    }



    /**
     * Set meta datas
     *
     *
     * @param string $title
     * @param string $desc
     * @param string $keywords
     * @return void
     */
    public static function setMeta($title='', $desc='', $keywords='')
    {
        self::$meta['title'] = $title;
        self::$meta['desc']  = $desc;
        self::$meta['keywords'] = $keywords;
    }


    /**
     * Include partials or others views files
     *
     * @param $file
     * @return void
     */
    public function inclure($file)
    {
        $file = sprintf(APP.'/views/%s.php', $file);
        if(is_file($file)){
            require_once $file;
        }else{
            echo sprintf('File %s not found ...', $file);
        }
    }


}