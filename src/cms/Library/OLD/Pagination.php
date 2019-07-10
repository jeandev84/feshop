<?php
namespace Framework\Library;


/**
 * Class Pagination
 *
 * @package Framework\Library
 */
class Pagination
{

    /**
     * @var int  $currentPage  [ Current Page ]
     * @var int  $perpage      [ Number of items to show per page ]
     * @var int  $total        [ Count Total records from database ]
     * @var int  $countPages   [ Count total of pages ]
     * @var int  $uri          [ Request URI ]
     * @var array $links       [ Links ]
     */
    public $currentPage;
    public $perpage;
    public $total;
    public $countPages;
    public $uri;
    /*
    public $links = [
        'back' => '', // ссылка Назад
        'forward' => '', // ссылка Вперед
        'startpage' => '', // ссылка в Начало
        'endpage' => '', // ссылка в Конец
        'page2left' => '', // вторая страница слева
        'page1left' => '', // первая страница слева
        'page2right' => '', // вторая страница справа
        'page1right' => '', // первая страница справа

    ];
    */


    /**
     * Pagination constructor.
     *
     * @param $page
     * @param $perpage
     * @param $total
     */
    public function __construct($page, $perpage, $total)
    {
        $this->perpage     = $perpage;
        $this->total       = $total;
        $this->countPages  = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri         = $this->getParams();
    }


    /**
     * Get Html code
     * TO Refactoring
     *  Create method
     *  - back()
     *  - forward()
     *  - start()
     *  - endpage
     *  - secondLeft()
     *  - firstLeft()
     *  - secondRight()
     *  - firstRight()
     *
     *  - generate(): generate links format
     */
    public function getHtml()
    {
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        // GET BACK LINK [ si on est pas sur la premiere page ]
        if( $this->currentPage > 1 )
        {
            # http://eshop.loc/category/casio?sort=name&filter=1,2,3&page=1
            $back = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage - 1). "'>&lt;</a></li>";
        }

        // GET FORWARD LINK
        if( $this->currentPage < $this->countPages )
        {
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>&gt;</a></li>";
        }

        // GET START-PAGE LINK
        if( $this->currentPage > 3 )
        {
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }

        // GET END-PAGE LINK
        if( $this->currentPage < ($this->countPages - 2) )
        {
            $endpage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }

        // GET SECOND_LEFT_PAGE LINK
        if( $this->currentPage - 2 > 0 )
        {
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-2). "'>" .($this->currentPage - 2). "</a></li>";
        }

        // GET FIRST_LEFT_PAGE LINK
        if( $this->currentPage - 1 > 0 )
        {
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-1). "'>" .($this->currentPage-1). "</a></li>";
        }

        // GET FIRST_RIGHT_PAGE LINK
        if( $this->currentPage + 1 <= $this->countPages )
        {
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>" .($this->currentPage+1). "</a></li>";
        }

        // GET SECOND_RIGHT_PAGE LINK
        if( $this->currentPage + 2 <= $this->countPages )
        {
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 2). "'>" .($this->currentPage + 2). "</a></li>";
        }

        // GET LINKS FORMATED
        return '<ul class="pagination">' . $startpage.$back.$page2left.$page1left.'<li class="active"><a>'.$this->currentPage.'</a></li>'.$page1right.$page2right.$forward.$endpage . '</ul>';
    }


    /**
     * Get object as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHtml();
    }


    /**
     * Get count pages
     *
     * @return int
     */
    public function getCountPages()
    {
        return ceil($this->total / $this->perpage) ?: 1;
    }


    /**
     * Get current Page
     *
     * @param $page
     * @return int
     */
    public function getCurrentPage($page)
    {
        if(!$page || $page < 1)
        {
            $page = 1;
        }

        if($page > $this->countPages)
        {
            $page = $this->countPages;
        }
        return $page;
    }


    /**
     *  Get Start
     *  start = (number_current_page - 1) * perpage
     *  SQL ...LIMIT start, perpage
     *
     * @return string
     */
    public function getStart()
    {
        return ($this->currentPage - 1) * $this->perpage;
    }


    /**
     * Get Params
     *
     * URL : eshop.loc/category/casio?page=2&sort=name&filter=1,2,3...
     *
     * URI: /category/casio
     * QUERY_STRING: page=2&sort=name&filter=1,2,3...
     *
     *  L'objectif est de recuperer tous les paramettres different de 'page=numero_de_page'
     *
     * @return string
     */
    public function getParams()
    {
        # LINK BEFORE : http://eshop.loc/category/casio?page=2&sort=name&filter=1,2,3
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);

        $uri = $url[0] . '?';

        if(isset($url[1]) && $url[1] != '')
        {
            $params = explode('&', $url[1]); /* debug($params); */

            foreach($params as $param)
            {
                # On choisit les parametres qui sont different de 'page=numberOfPage'
                if(!preg_match("#page=#", $param))
                {
                    $uri .= sprintf('%s&amp;', $param);
                }
            }
        }
        # LINK AFTER : /category/casio?sort=name&filter=1,2,3
        return urldecode($uri);
    }
}