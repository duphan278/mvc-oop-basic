<?php
 class HomeController {
    protected function render($view, $data = []) {
        extract($data);
        $view = 'auth/login';
        require_once PATH_VIEWS_MAIN;
    }
    protected function view_chucnang($folder,$page) {
        $view = $folder.'/dashboard';
        $into = 'chucnang/'. $page;
        require_once PATH_VIEWS_MAIN;
    }
    protected function print_infor($folder,$page,$data) {
        $view = $folder.'/dashboard';
        $into = 'chucnang/'. $page;
        require_once PATH_VIEWS_MAIN;
    }
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
    function getRealTime() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y-m-d');
    }

 }
 