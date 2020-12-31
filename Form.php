<?php


namespace formGenereitor;


require_once 'base/FormBase.php';
require_once 'ui/FormUI.php';

class Form extends base\FormBase implements ui\FormUI
{

    public function start()
    {
        $atributesPrint = [];
        foreach ($this->attributes as $attribute => $value){
            if("" != $value and !is_array($value)){
                $atributesPrint[] = "$attribute='$value'";
            }
        }
        
        $ret = "<form ". implode(" ", $atributesPrint) .">\n";
        
        return $ret;
    }
    
    public function end()
    {       
        $ret = "</form>\n";
        return $ret;
    }
    
    public function createField($name, $value = '')
    {
        $field = new Field($name, $value);
        $this->addField($field);
        $field->setForm($this);
        return $field;
    }
}