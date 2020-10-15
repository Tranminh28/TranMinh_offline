<?php
class GroupController extends Controller
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
        $totalItems = $this->_model->countItems($this->_arrParam, null);
        $config['totalItemsPerPage'] = 20;
        $config['pageRange'] = 3;
        $this->setPagination($config);

        $this->_view->pagination = new Pagination($totalItems, $this->_pagination);
        $this->_view->items = $this->_model->listItems($this->_arrParam, null);
        $this->_view->countActive = $this->_model->countItems($this->_arrParam, ['task' => 'count-active']);
        $this->_view->countInactive = $this->_model->countItems($this->_arrParam, ['task' => 'count-inactive']);
        $this->_view->title = ucfirst($this->_arrParam['controller']) . ' Manager :: List';
        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function changeStatusAction()
    {
        $this->_model->changeStatus($this->_arrParam, null);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function ajaxChangeStatusAction()
    {
        $result = $this->_model->changeStatus($this->_arrParam, ['task' => 'ajax-change-status']);
        echo json_encode($result);
    }

    public function ajaxChangeGroupACPAction()
    {
        $result = $this->_model->changeStatus($this->_arrParam, ['task' => 'ajax-change-status']);
        echo json_encode($result);
    }

    public function activeAction()
    {
        $this->_model->changeStatus($this->_arrParam, ['task' => 'active']);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function inactiveAction()
    {
        $this->_model->changeStatus($this->_arrParam, ['task' => 'inactive']);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function deleteAction()
    {
        $this->_model->delete($this->_arrParam, null);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function multiDeleteAction()
    {
        $this->_model->delete($this->_arrParam, ['task' => 'multi-delete']);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function formAction()
    {
        $this->_view->title = ucfirst($this->_arrParam['controller']) . ' Manager :: Add';

        if (isset($this->_arrParam['id']) && !isset($this->_arrParam['form']['token'])) {
            $this->_view->title = ucfirst($this->_arrParam['controller']) . ' Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
            if (empty($this->_arrParam['form'])) URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
        }

        if (isset($this->_arrParam['form']['token'])) {
            $validate = new Validate($this->_arrParam['form']);
            $validate->addRule('name', 'string', ['min' => 3, 'max' => 255])
                ->addRule('status', 'status', ['deny' => ['default']])
                ->addRule('group_acp', 'status', ['deny' => ['default']]);
            $validate->run();
            $this->_arrParam['form'] = $validate->getResult();
            if ($validate->isValid() == false) {
                $this->_view->errors = $validate->showErrors();
            } else {
                $task = isset($this->_arrParam['form']['id']) ? 'edit' : 'add';
                $id = $this->_model->save($this->_arrParam, ['task' => $task]);


                if ($this->_arrParam['type'] == 'save-close')   URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
                if ($this->_arrParam['type'] == 'save-new')     URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'form');
                if ($this->_arrParam['type'] == 'save')         URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'form', ['id' => $id]);
            }
        }

        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render($this->_arrParam['controller'] . '/form');
    }
}
