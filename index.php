<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\DB;
class AdminController extends Controller {
	public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'admin';
	}
	public function loginAction() {	
	if(isset($_SESSION['admin'])) {
		$this->view->redirect('admin/add');
	}
	if(!empty($_POST)) {
		if(!$this->model->loginValidate($_POST)) {
				$this->view->message('ErrorCode:204', $this->model->error);
			}
			$_SESSION['admin'] = true;
			$this->view->location('admin/add');
		}
		$this->view->render('Логин');
	}
	public function addAction() {	
		if(!empty($_POST)) {
			if(!$this->model->postValidate($_POST, 'add')) {
				$this->view->message('ErrorCode:204', $this->model->error);
			}
			$this->model->postAdd($_POST);

			$file_name = $_FILES['img']['name'];
  			$file_tmp = $_FILES['img']['tmp_name'];
  			move_uploaded_file($file_tmp, "/public/materials/".$file_name);

			$this->view->message('200', 'OK');
		}
		$this->view->render('Добавить пост');
	}
	public function editAction() {
		if(!empty($_POST)) {
			if(!$this->model->postValidate($_POST, 'edit')) {
				$this->view->message('ErrorCode:204', $this->model->error);
			}
			$this->view->message('200', 'OK');
		}
		$this->view->render('Редактировать пост');
	}
	public function deleteAction() {
		exit('Удалить пост');
	}
	public function logoutAction() {
		unset($_SESSION['admin']);
		$this->view->redirect('admin/login');
	}
	public function postsAction() {
		$this->view->render('Посты');
	}
}