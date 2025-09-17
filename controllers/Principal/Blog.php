<?php
class Blog extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cargarModel('Blog');
    }

    public function index()
    {
        $data['title'] = 'Blog';
        $data['subtitle'] = 'Entradas del Blog';
        $data['entradas'] = $this->model->getEntradas();
        $this->views->getView('principal/blog/index', $data);
    }
}
