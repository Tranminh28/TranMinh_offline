<?php

class FormBackend
{
    public static function input($type, $id, $name, $value, $class = null, $style = null)
    {
        $strStyle = ($style == null) ? '' : "style='$style'";
        $strClass = ($class == null) ? '' : "class='$class'";

        $xhtml = sprintf('<input type="%s" id="%s" name="%s" value="%s" %s %s>', $type, $id, $name, $value, $strClass, $strStyle);

        return $xhtml;
    }

    public static function select($name, $class, $arrValue, $keySelect = 'default', $style = null, $attribute = '')
	{
		$xhtml = '<select style="' . $style . '" name="' . $name . '" class="' . $class . '" ' . $attribute . '>';
		foreach ($arrValue as $key => $value) {
			if ($key == $keySelect && is_numeric($keySelect)) {
				$xhtml .= '<option selected value = "' . $key . '">' . $value . '</option>';
			} else {
				$xhtml .= '<option value = "' . $key . '">' . $value . '</option>';
			}
		}
		$xhtml .= '</select>';
		return $xhtml;
	}

	public static function selectNonNumeric($name, $class, $arrValue, $keySelect = 'default', $style = null)
	{
		$xhtml = '<select style="' . $style . '" name="' . $name . '" class="' . $class . '" >';
		foreach ($arrValue as $key => $value) {
			if ($key == $keySelect) {
				$xhtml .= '<option selected value = "' . $key . '">' . $value . '</option>';
			} else {
				$xhtml .= '<option value = "' . $key . '">' . $value . '</option>';
			}
		}
		$xhtml .= '</select>';
		return $xhtml;
	}

    public static function formGroup($labelName, $input, $required = false)
	{
		$required = $required ? 'required' : '';
		$xhtml = '
		<div class="form-group row align-items-center">
			<label class="col-sm-2 col-form-label text-sm-right ' . $required . '">' . $labelName . '</label>
			<div class="col-xs-12 col-sm-8">
				' . $input . '
			</div>
		</div>
		';

		return $xhtml;
	}
}
