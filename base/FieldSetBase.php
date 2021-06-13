<?php

namespace formGenereitor\base;

use formGenereitor\Field;
use formGenereitor\interfaces\{FieldInterface, FormInterface};

/**
 * @author Rafael Perez <rafaelperez7461@gmail.com>
 * Displays <a href="https://opensource.org/licenses/MIT">The MIT License</a>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @package formGenereitor1.0.0
 */
abstract class FieldSetBase 
{    
    protected $attributes = ['fields' => [],];
    protected $legend = "";
    protected $readOnly = false;
    protected $showFieldLabel = true;
    protected $showFieldBootstrap = false;
    protected $form = null;
    protected static $id = 1;

    public function __construct($legend = "", $fields = [])
    {
        $this->setLegend($legend);
        $this->setFields($fields);
        $this->setId("fieldset_" . self::$id++);
    }
    
    /**
     * If an attribute exists, it gets the value.
     * 
     * @param string $attrName
     * @return string|null
     */
    public function get(string $attrName)
    {
        $attrName = strtolower($attrName);
        $ret = @$this->getAttributes()[$attrName];
        return $ret;
    }
    
    /**
     * 
     * @param string $attrName
     * @param $value
     * @return $this
     */
    public function set(string $attrName, $value)
    {
        $attrName = strtolower($attrName);
        if(isset($this->attributes[$attrName])){
            $this->attributes[$attrName] = $value;
        }
        
        return $this;
    }

    /**
     * @return string
     */
    protected function renderAttributes()
    {
        $ret = [];
        foreach ($this->attributes as $attribute => $value){
            if("" != $value and !is_array($value)){
                $ret[] = "$attribute='$value'";
            }
        }
        
        return implode(" ", $ret);
    }

    /**
     * @return FormInterface|null
     */
    public function getForm()
    {
        return $this->form;
    }


    /**
     * @param FormInterface $form
     * @return $this
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $ret = "<fieldset {$this->renderAttributes()}>\n";
        if("" != $this->getLegend()){
            $ret .= "\t<legend>{$this->getLegend()}</legend>\n";
        }
        
        foreach ($this->getFields() as $key => $field){
            if($field instanceof FieldInterface){
                $f = $field;
            } else {
                $f = new Field($key, $field);
            }
            
            $f->showLabel($this->showFieldLabel)
                ->setReadonly($this->getReadOnly())
                ->showBootstrap($this->showFieldBootstrap);
            
            $ret .= $f->render();
        }
        
        $ret .= "</fiendset>\n";
        
        return $ret;
    }

    /**
     * @param $name
     * @param string $value
     * @param string $type
     * @return $this
     */
    public function addField($name, $value = "", $type = "")
    {
        $f = new Field($name, $value, $type);
        $this->attributes['fields'][$f->getId()] = $f;
        return $this;
    }

    /**
     * @param FieldInterface $field
     * @return $this
     */
    public function addFieldObj(FieldInterface $field)
    {
        $this->attributes['fields'][$field->getId()] = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString() 
    {
        return $this->render();
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        $ret['legend'] = $this->getLegend();
        $ret += array_filter($this->getAttributes());
        $ret['fields'] = [];
        
        foreach($this->getFields() as $field){
            $ret['fields'][] = $field->toArray();
        }
        
        return json_encode($ret);
    }

    /**
     * @return array[]|null
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return array[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getId()
    {
        return @$this->attributes['id'];
    }

    /**
     * @return array
     */
    public function getClass()
    {
        return @$this->attributes['class'];
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->attributes['fields'];
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getStyle()
    {
        return @$this->attributes['style'];
    }

    /**
     * @param $style
     * @return $this
     */
    public function setStyle($style)
    {
        $this->attributes['style'] = str_replace('"', "'", $style);
        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    /**
     * You can receive an array with the key-value pair to create or add fields from it,
     * or you can receive an array of objects of type FieldInterface and add them to the list of fields
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $name => $value){
            if($value instanceof FieldInterface){
                $f = $value;
            } else {
                $f = new Field($name, $value);
            }

            $this->attributes['fields'][$f->getId()] = $f;
        }
        
        return $this;
    }

    /**
     * @return string
     */
    public function getLegend() 
    {
        return $this->legend;
    }

    /**
     * @return bool
     */
    public function getReadOnly() 
    {
        return $this->readOnly;
    }

    /**
     * @param $legend
     * @return $this
     */
    public function setLegend($legend) 
    {
        $this->legend = $legend;
        return $this;
    }

    /**
     * @param $readOnly
     * @return $this
     */
    public function setReadOnly($readOnly) 
    {
        $this->readOnly = true === $readOnly;
        return $this;
    }

    /**
     * @param bool $show
     * @return $this
     */
    public function showFieldLabel($show = true) 
    {
        $this->showFieldLabel = true === $show;
        return $this;
    }

    /**
     * @param bool $show
     * @return $this
     */
    public function showFieldBootstrap($show = true) 
    {
        $this->showFieldBootstrap = true === $show;
        return $this;
    }
    
}