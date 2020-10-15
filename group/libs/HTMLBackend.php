<?php
class HTMLBackend
{
    public static function showItemStatus($module, $controller, $id, $statusValue)
    {
        $xhtml = '';
        $class = 'success';
        $icon = 'check';
        $link = URL::createLink($module, $controller, 'ajaxChangeStatus', ['id' => $id, 'status' => $statusValue]);

        if ($statusValue == 'inactive') {
            $class = 'danger';
            $icon = 'minus';
        }

        $xhtml = sprintf('<a href="%s" class="my-btn-state btn-status rounded-circle btn btn-sm btn-%s"><i class="fas fa-%s"></i></a>', $link,  $class, $icon);
        return $xhtml;
    }

    public static function showItemGroupACP($module, $controller, $id, $groupACPValue)
    {
        $xhtml = '';
        $class = 'success';
        $icon = 'check';
        $link = URL::createLink($module, $controller, 'ajaxChangeGroupACP', ['id' => $id, 'status' => $groupACPValue]);

        if ($groupACPValue == 0) {
            $class = 'danger';
            $icon = 'minus';
        }

        $xhtml = sprintf('<a href="%s" class="my-btn-state rounded-circle btn btn-sm btn-%s"><i class="fas fa-%s"></i></a>', $link, $class, $icon);
        return $xhtml;
    }

    public static function showItemHistory($by, $time)
    {
        $time = HelperBackend::formatDatetime($time);
        $xhtml = '
        <p class="mb-0 history-by"><i class="far fa-user"></i> ' . $by . '</p>
        <p class="mb-0 history-time"><i class="far fa-clock"></i> ' . $time . '</p>
        ';
        return $xhtml;
    }

    public static function createSelectBox($name, $class, $arrValue, $keySelect = 'default', $style = null)
    {
        $xhtml = '<select style="' . $style . '" name="' . $name . '" class="' . $class . '" >';
        foreach ($arrValue as $key => $value) {
            if ($key == $keySelect && is_numeric($keySelect)) {
                $xhtml .= '<option selected="selected" value = "' . $key . '">' . $value . '</option>';
            } else {
                $xhtml .= '<option value = "' . $key . '">' . $value . '</option>';
            }
        }
        $xhtml .= '</select>';
        return $xhtml;
    }

    public static function showFilterButtons($params, $countStatusValues)
    {
        $xhtml = '';
        $currentStatus = $params['status'] ?? 'all';

        foreach ($countStatusValues as $key => $value) {
            $link = URL::createLink($params['module'], $params['controller'], $params['action'], ['status' => $key]);
            $classColor = 'secondary';

            if ($currentStatus == $key) $classColor = 'info';

            $name = '';
            switch ($key) {
                case 'all':
                    $name = 'All';
                    break;
                case 'active':
                    $name = 'Active';
                    break;
                case 'inactive':
                    $name = 'Inactive';
                    break;
            }
            $xhtml .= sprintf('<a href="%s" class="mr-1 btn btn-sm btn-%s">%s <span class="badge badge-pill badge-light">%s</span></a>', $link, $classColor, $name, $value);
        }

        return $xhtml;
    }

    public static function showNotify()
    {
        $xhtml = '';

        if (!empty(Session::get('notify'))) {
            $xhtml = '
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span>' . Session::get('notify') . '</span>
            </div>
            ';
            Session::delete('notify');
        }
        return $xhtml;
    }

    public static function createActionButton($link, $class, $textContent)
    {
        $xhtml = sprintf('<a href="%s" class="btn btn-sm %s"> %s</a>', $link, $class, $textContent);
        return $xhtml;
    }
}
