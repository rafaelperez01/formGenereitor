<?php

namespace formGenereitor\base;

use formGenereitor\Field;
use formGenereitor\FieldSet;
use formGenereitor\interfaces\{FieldInterface, FieldSetInterface};

/**
 * @author Rafael Perez <rafaelperez7461@gmail.com>
 * Displays <a href="https://opensource.org/licenses/MIT">The MIT License</a>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @package formGenereitor1.0.0
 */
abstract class FormBase 
{
    protected $readOnly = false;
    protected $attributes = ['fieldsets' => [], 'fields' => [], 'accept' => 'image/*,.pdf', 'enctype' => 'multipart/form-data'];
    
    protected $showBootstrap = false;

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_PUT = 'put';
    const METHOD_DELETE = 'delete';
    
    const METHOD_LIST = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_DELETE,
    ];
    
    protected static $id = 1;

    protected $language = 'en';

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Form constructor.
     * @param array $fiels
     * @param string $action
     * @param string $method
     */
    public function __construct($fiels = [], $action = "", $method = 'post')
    {
        $this->setFields($fiels);
        $this->setAction($action);
        $this->setMethod($method);
        $formId = 'form_' . self::$id++;
        $this->setId($formId);
        $this->setName($formId);
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
     * Set a list of fields as read-only fields
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsReadOnly(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setReadonly();
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Set a list of fields as disabled fields
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsDisableds(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setDisabled();
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Set a list of fields as hidden fields
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsHidden(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setType('hidden')->showLabel(false);
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Configure a list of fields as fields of type textArea
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsTextArea(array $fieldIdList)
    {
        if(!empty($fieldIdList)){
            foreach ($fieldIdList as $id){
                if($f = $this->getFieldById($id)){
                    $f->setType('textarea');
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Set options for a field (select, list, optgroup)
     * @param string $fieldId
     * @param array $options
     * @return $this
     */
    public function setFieldOptions($fieldId, array $options)
    {
        if($f = $this->getFieldById($fieldId) and !empty($options)){
            $f->setOptions($options);
        }
        
        return $this;
    }

    /**
     * Indicates if bootstrap styles should be displayed
     * @param boolean $show
     * @return $this
     */
    public function showBootstrap($show = true)
    {
        $this->showBootstrap = true === $show;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowBootstrap()
    {
        return $this->showBootstrap;
    }

    /**
     * Add or replace field
     * @param FieldInterface $field
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $field->setForm($this);
        $this->attributes['fields'][$field->getId()] = $field;
        return $this;
    }
    
    /**
     * Add a list of fields (the items have to be objects of type FieldInterface)
     * @param array <FieldInterface> $fieldList
     * @return $this
     */
    public function addFieldList(array $fieldList)
    {
        if(!empty($fieldList)){
            foreach ($fieldList as $field){
                $this->addField($field);                
            }
        }
        
        return $this;
    }
    
    /**
     * You can receive an array with the key-value pair to create and add fields from it,
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

            $f->setForm($this);
            $this->attributes['fields'][$f->getId()] = $f;
        }

        return $this;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getFieldById($id)
    {
        $ret = null;
        if(isset($this->attributes['fields'][$id])){
            $ret = $this->attributes['fields'][$id];
        }
        
        return $ret;
    }
    
    /**
     * Add or replace a fieldset in the list of fieldsets
     * @param FieldSetInterface $fieldset
     * @return $this
     */
    public function addFieldset(FieldSetInterface $fieldset)
    {
        $fieldset->setForm($this);
        $this->attributes['fieldsets'][$fieldset->getId()] = $fieldset;
        return $this;
    }
    
    /**
     * Add a list of fieldset (items have to be of type FieldSetInterface)
     * @param array <FieldSetInterface> $fieldsetList
     * @return $this
     */
    public function addFieldsetList(array $fieldsetList)
    {
        if(!empty($fieldsetList)){
            foreach ($fieldsetList as $fieldset){
                $this->addFieldset($fieldset);
            }
        }
        
        return $this;
    }
    
    /**
     * You can receive an array with the key-value pair to create and add fieldset from it,
     * or you can receive an array of objects of type FieldSetInterface and add them to the fieldset list
     * @param array $fieldsets
     * @return $this
     */
    public function setFieldsets(array $fieldsets)
    {
        foreach ($fieldsets as $key => $fieldSet){
            if($fieldSet instanceof FieldSetInterface){
                $f = $fieldSet;
            } else {
                $f = new FieldSet($fieldSet);
            }
            
            $f->setForm($this);
            $this->attributes['fieldsets'][$f->getId()] = $f;
        }

        return $this;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getFieldsetById($id)
    {
        $ret = null;
        if(isset($this->attributes['fieldsets'][$id])){
            $ret = $this->attributes['fieldsets'][$id];
        }
        
        return $ret;
    }

    /**
     * Render the entire form (fieldsets and fields)
     * @return string
     */
    public function render()
    {
        $ret = "<form {$this->renderAttributes()}>\n";
        $ret .= $this->renderFieldSets();
        $ret .= $this->renderFields();
        $ret .= "</form>\n";

        return $ret;
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
     * @return string
     */
    protected function renderFieldSets()
    {
        $ret = "";
        if(!empty($this->getFieldsets())){
            foreach($this->getFieldsets() as $fieldset){
                if($this->readOnly){
                    $fieldset->setReadOnly();
                }
                $ret .= $fieldset->render();
            }
        }

        return $ret;
    }

    /**
     * @return string
     */
    protected function renderFields()
    {
        $ret = "";
        if(!empty($this->getFields())){
            
            foreach($this->getFields() as $field){
                /**
                 * @var FieldBase $field
                 */
                if($this->readOnly){
                    $field->setReadOnly();
                }                
                $ret .= $field->render();
            }
        }

        return $ret;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Returns the form converted to json
     * @return string JSON
     */
    public function toJson()
    {
        $paramList = [];
        foreach($this->attributes as $attributes => $value){
            if("" != $value and !is_array($value)){
                $paramList[$attributes] = $value;
            }
        }

        $fieldsetList = [];
        if(!empty($this->getFieldsets())){
            foreach($this->getFieldsets() as $fieldset){
                $fieldsetList[] = $fieldset->toArray();
            }
        }
        $paramList['fieldsets'] = $fieldsetList;

        $fieldList = [];
        if(!empty($this->getFields())){
            foreach($this->getFields() as $field){
                $fieldList[] = $field->toArray();
            }
        }
        $paramList['fields'] = $fieldList;

        return json_encode($paramList);
    }

    /**
     * Returns the form converted into an array
     * @return array
     */
    public function toArray(): array {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    public function end()
    {       
        $ret = "</form>\n";
        return $ret;
    }

    /**
     * @param $name
     * @param string $value
     * @param string $type
     * @return Field
     */
    public function createField($name, $value = '', $type = '')
    {
        $field = new Field($name, $value, $type);
        $this->addField($field);
        $field->setForm($this);
        $field->setLanguage($this->getLanguage());
        return $field;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return @$this->attributes['id'];
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return @$this->attributes['class'];
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return @$this->attributes['action'];
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return @$this->attributes['method'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return @$this->attributes['name'];
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return @$this->attributes['caption'];
    }

    /**
     * @return mixed
     */
    public function getFieldsets()
    {
        return $this->attributes['fieldsets'];
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->attributes['fields'];
    }

    /**
     * @return mixed
     */
    public function getAutocomplete()
    {
        return @$this->attributes['autocomplete'];
    }

    /**
     * @return mixed
     */
    public function getNovalidate()
    {
        return @$this->attributes['novalidate'];
    }

    /**
     * @return mixed
     */
    public function getEnctype()
    {
        return @$this->attributes['enctype'];
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return @$this->attributes['target'];
    }

    /**
     * @return mixed
     */
    public function getAccept()
    {
        return @$this->attributes['accept'];
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
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->attributes['action'] = $action;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }

    /**
     * @param $caption
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->attributes['caption'] = $caption;
        return $this;
    }

    /**
     * @param $autocomplete
     * @return $this
     */
    public function setAutocomplete($autocomplete)
    {
        $this->attributes['autocomplete'] = $autocomplete;
        return $this;
    }

    /**
     * @param $novalidate
     * @return $this
     */
    public function setNovalidate($novalidate)
    {
        $this->attributes['novalidate'] = $novalidate;
        return $this;
    }

    /**
     * @param $enctype
     * @return $this
     */
    public function setEnctype($enctype)
    {
        $this->attributes['enctype'] = $enctype;
        return $this;
    }

    /**
     * @param $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->attributes['target'] = $target;
        return $this;
    }

    /**
     * @param $accept
     * @return $this
     */
    public function setAccept($accept)
    {
        $this->attributes['accept'] = $accept;
        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $method = strtolower(trim($method));
        $validMethod = in_array($method, self::METHOD_LIST) ? $method : self::METHOD_POST;
        $this->attributes['method'] = $validMethod;
        return $this;
    }
    
    /**
     * Validate if the values of the fields are correct (type, length and format)
     * @return boolean
     */
    public function validate()
    {
        $ret = true;
        $this->loadDataFromRequest();
        foreach ($this->getFields() as $field){
            /** @var FieldBase $field  */
            $ret *= $field->validate();
        }
        
        return $ret;
    }
    
    /**
     * Fill the values of the fields with the data that comes from the post and get methods
     * @return $this
     */
    public function loadDataFromRequest()
    {
        switch ($this->getMethod()){
            case 'get':
                $this->loadDataFromGet();
                break;
            case 'post':
                $this->loadDataFromPost();
                break;
        }
        
        return $this;
    }

    /**
     * @return $this
     */
    protected function loadDataFromGet()
    {
        foreach ($this->getFields() as $field){
            if($value = filter_input(INPUT_GET, $field->getName())){
                $field->setValue($value);
            }
        }
        
        return $this;
    }

    /**
     * @return $this
     */
    protected function loadDataFromPost()
    {
        foreach ($this->getFields() as $field){
            /**
             * @var FieldBase $field
             */
            $fieldName = trim($field->getName(), "[]");
            switch($field->getType()){
                case 'radio':
                    $value = filter_input(INPUT_POST, $fieldName);
                    $field->setChecked($value == $field->getValue());
                    break;

                case 'checkbox':
                    $value = filter_input(INPUT_POST, $fieldName, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                    if(is_array($value)){
                        $field->setChecked(in_array($field->getValue(), $value));
                    } else {
                        $value = filter_input(INPUT_POST, $fieldName);
                        $field->setChecked($value == $field->getValue());
                    }
                    break;

                default:
                    $value = filter_input(INPUT_POST, $fieldName);
                    $field->setValue($value);
                    break;
            }
        }
        
        return $this;
    }
}
