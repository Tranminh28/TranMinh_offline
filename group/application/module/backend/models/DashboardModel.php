<?php
class DashboardModel extends Model
{
    public function countItems($params, $options = null)
    {
        $result = null;
        
        if ($options['task'] == 'count-group') {
            $this->setTable(TBL_GROUP);
        }

        if ($options['task'] == 'count-user') {
            $this->setTable(TBL_USER);
        }

        $query = "SELECT count(`id`) AS `total` FROM `$this->table`";
        $result = $this->fetchRow($query)['total'];

        return $result;
    }
}