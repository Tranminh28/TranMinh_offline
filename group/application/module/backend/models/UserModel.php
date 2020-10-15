<?php
class UserModel extends Model
{
    protected $fieldSearchAccepted = ['id', 'name'];
    protected $crudNotAccepted = ['token'];

    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
    }

    public function listItems($params, $options = null)
    {
        $result = null;
        if ($options == null) {
            $query[]	= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`status`, `u`.`fullname`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` AS `group_name`";
            $query[]	= "FROM `$this->table` AS `u`, `". TBL_GROUP . "` AS `g`";
            $query[]	= "WHERE `u`.`group_id` = `g`.`id`";

            if (isset($params['search']) && $params['search'] != '') {
                $query[] = "AND (";
                foreach ($this->fieldSearchAccepted as $field) {
                    $query[] = "`$field` LIKE '%{$params['search']}%'";
                    $query[] = "OR";
                }
                array_pop($query);
                $query[] = ")";
            }

            if (isset($params['status']) && $params['status'] != 'all') $query[] = "AND `status` = '{$params['status']}'";

            if (isset($params['filter_groupacp']) && $params['filter_groupacp'] != 'default') $query[] = "AND `group_acp` = " . $params['filter_groupacp'];

            $pagination         = $params['pagination'];
            $totalItemsPerPage  = $pagination['totalItemsPerPage'];
            $position   = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
            $query[]    = "LIMIT $position, $totalItemsPerPage";

           $query = implode(' ', $query);
            $result = $this->fetchAll($query);
        }

        return $result;
    }

    public function countItems($params, $options = null)
    {
        if ($options == null) {
            $query = "SELECT COUNT(`id`) as `total` FROM `$this->table`";

            if (isset($params['status']) && $params['status'] != 'all') {
                $query .= "WHERE `status` = '{$params['status']}'";
            }

            $result = $this->fetchRow($query);
            return $result['total'];
        }

        if ($options['task'] == 'count-active') {
            $query = "SELECT COUNT(`id`) as `total` FROM `$this->table` WHERE `status` = 'active'";
            $result = $this->fetchRow($query);
            return $result['total'];
        }

        if ($options['task'] == 'count-inactive') {
            $query = "SELECT COUNT(`id`) as `total` FROM `$this->table` WHERE `status` = 'inactive'";
            $result = $this->fetchRow($query);
            return $result['total'];
        }
    }

    public function changeStatus($params, $options = null)
    {
        $modified = date(DB_DATETIME_FORMAT);
        $modifiedBy = 'admin';

        if ($options == null) {
            $status = $params['status'] == 'active' ? 'inactive' : 'active';
            $query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = {$params['id']}";
            Session::set('notify', SUCCESS_UPDATE_STATUS);
        }

        if ($options['task'] == 'ajax-change-status') {
            $status = $params['status'] == 'active' ? 'inactive' : 'active';
            $id = $params['id'];
            $query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
            $this->query($query);
            return [
                'id' => $id,
                'status' => $status,
                'link' => URL::createLink($params['module'], $params['controller'], 'ajaxChangeStatus', ['id' => $id, 'status' => $status]),
                'modified' => HTMLBackend::showItemHistory($modifiedBy, $modified)
            ];
        }

        if ($options['task'] == 'active') {
            $status = 'active';
            $ids = implode(',', $params['checkbox']);
            $query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN ($ids)";
            Session::set('notify', SUCCESS_UPDATE_STATUS);
        }

        if ($options['task'] == 'inactive') {
            $status = 'inactive';
            $ids = implode(',', $params['checkbox']);
            $query = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` IN ($ids)";
            Session::set('notify', SUCCESS_UPDATE_STATUS);
        }

        $this->query($query);
    }

    public function delete($params, $options = null)
    {
        if ($options == null) {
            $id = $params['id'];
            $query = "DELETE FROM `$this->table` WHERE `id` = $id";
            $this->query($query);
            Session::set('notify', SUCCESS_DELETE);
        }

        if ($options['task'] == 'multi-delete') {
            $ids = implode(',', $params['checkbox']);
            $query = "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
            $this->query($query);
            Session::set('notify', SUCCESS_DELETE);
        }
    }

    public function save($params, $options = null)
    {
        if ($options['task'] == 'add') {
            $params['form']['created'] = date(DB_DATETIME_FORMAT);
            $params['form']['created_by'] = 'admin';
            $data = array_diff_key($params['form'], array_flip($this->crudNotAccepted));
            return $this->insert($data);
        }

        if ($options['task'] == 'edit') {
            $params['form']['modified'] = date(DB_DATETIME_FORMAT);
            $params['form']['modified_by'] = 'admin';

            $data = array_diff_key($params['form'], array_flip($this->crudNotAccepted));
            $this->update($data, [['id', $params['form']['id']]]);
            return $params['form']['id'];
        }
    }

    public function infoItem($params, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `name`, `group_acp`, `status`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $params['id'] . "'";
            $query      = implode(" ", $query);
            $result     = $this->fetchRow($query);
            return $result;
        }
    }
}
