<?php
class formHelper
{
  function input($type = 'text', $name, $value = '', $params = '', $id='')
  {
    if (!empty($value)) $value = "value=\"${value}\"";
    $parameters = $this->getParams($params);
    return "<input type=\"${type}\" name=\"${name}\" id=\"${id}\" ${value} ${parameters} />";
  }
  function textarea($name, $value = '', $params = '')
  {
    $parameters = $this->getParams($params);
    return "<textarea name=\"${name}\" ${parameters} >${value}</textarea>";
  }
  function select($name, $selected, $value = '', $params = '', $label = '')
  {
    $values = (!empty($label)) ? "<option value=\"\">${label}</option>" : "";
    $parameters = $this->getParams($params);
    if (is_array($value))
    {
      foreach($value as $k => $v)
      {
        $s = ($selected == $k) ? 'selected="selected"' : '';
        $values.= "\n \t<option value=\"${k}\" ${s}>" . $v . "</option>";
      }
    }
    return "<select name=\"${name}\" ${parameters} >${values}\n</select>";
  }
  private function getParams($params)
  {
    $parameters = "";
    if (is_array($params)):
      foreach($params as $k => $v):
        $parameters.= " $k=\"$v\"";
      endforeach;
    endif;
    return $parameters;
  }
}
