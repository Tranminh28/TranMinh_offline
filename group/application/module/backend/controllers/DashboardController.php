<?php
class DashboardController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('backend/adminlte/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        $this->_view->countGroup = $this->_model->countItems($this->_arrParam, ['task' => 'count-group']);
        $this->_view->countUser = $this->_model->countItems($this->_arrParam, ['task' => 'count-user']);
        $this->_view->render('dashboard/index');
    }
}
