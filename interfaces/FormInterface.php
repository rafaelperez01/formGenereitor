<?php

namespace formGenereitor\interfaces;

use formGenereitor\Field;

/**
 * @author Rafael Perez <rafaelperez7461@gmail.com>
 * Displays <a href="https://opensource.org/licenses/MIT">The MIT License</a>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @package formGenereitor1.0.0
 */
interface FormInterface
{
    /**
     * @return string
     */
    public function getLanguage(): string;

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage(string $language);

    /**
     * @param $readOnly
     * @return $this
     */
    public function setReadOnly($readOnly);

    /**
     * Set a list of fields as read-only fields
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsReadOnly(array $fieldIdList);

    /**
     * Set a list of fields as disabled fields
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsDisableds(array $fieldIdList);

    /**
     * Set a list of fields as hidden fields
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsHidden(array $fieldIdList);

    /**
     * Configure a list of fields as fields of type textArea
     * @param array $fieldIdList
     * @return $this
     */
    public function setFieldsAsTextArea(array $fieldIdList);

    /**
     * Set options for a field (select, list, optgroup)
     * @param string $fieldId
     * @param array $options
     * @return $this
     */
    public function setFieldOptions($fieldId, array $options);

    /**
     * Indicates if bootstrap styles should be displayed
     * @param boolean $show
     * @return $this
     */
    public function showBootstrap($show = true);

    /**
     * @return bool
     */
    public function getShowBootstrap();

    /**
     * Add or replace field
     * @param FieldInterface $field
     * @return $this
     */
    public function addField(FieldInterface $field);

    /**
     * Add a list of fields (the items have to be objects of type FieldInterface)
     * @param array <FieldInterface> $fieldList
     * @return $this
     */
    public function addFieldList(array $fieldList);

    /**
     * You can receive an array with the key-value pair to create and add fields from it,
     * or you can receive an array of objects of type FieldInterface and add them to the list of fields
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields);

    /**
     * @param $id
     * @return mixed|null
     */
    public function getFieldById($id);

    /**
     * Add or replace a fieldset in the list of fieldsets
     * @param FieldSetInterface $fieldset
     * @return $this
     */
    public function addFieldset(FieldSetInterface $fieldset);

    /**
     * Add a list of fieldset (items have to be of type FieldSetInterface)
     * @param array <FieldSetInterface> $fieldsetList
     * @return $this
     */
    public function addFieldsetList(array $fieldsetList);

    /**
     * You can receive an array with the key-value pair to create and add fieldset from it,
     * or you can receive an array of objects of type FieldSetInterface and add them to the fieldset list
     * @param array $fieldsets
     * @return $this
     */
    public function setFieldsets(array $fieldsets);

    /**
     * @param $id
     * @return mixed|null
     */
    public function getFieldsetById($id);

    /**
     * Render the entire form (fieldsets and fields)
     * @return string
     */
    public function render();

    /**
     * Returns the form converted to json
     * @return string JSON
     */
    public function toJson();

    /**
     * Returns the form converted into an array
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function start();

    /**
     * @return string
     */
    public function end();

    /**
     * @param $name
     * @param string $value
     * @param string $type
     * @return Field
     */
    public function createField($name, $value = '', $type = '');

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getClass();

    /**
     * @return mixed
     */
    public function getAction();

    /**
     * @return mixed
     */
    public function getMethod();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getCaption();

    /**
     * @return mixed
     */
    public function getFieldsets();

    /**
     * @return mixed
     */
    public function getFields();

    /**
     * @return mixed
     */
    public function getAutocomplete();

    /**
     * @return mixed
     */
    public function getNovalidate();

    /**
     * @return mixed
     */
    public function getEnctype();

    /**
     * @return mixed
     */
    public function getTarget();

    /**
     * @return mixed
     */
    public function getAccept();

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class);

    /**
     * @param $action
     * @return $this
     */
    public function setAction($action);

    /**
     * @param $name
     * @return $this
     */
    public function setName($name);

    /**
     * @param $caption
     * @return $this
     */
    public function setCaption($caption);

    /**
     * @param $autocomplete
     * @return $this
     */
    public function setAutocomplete($autocomplete);

    /**
     * @param $novalidate
     * @return $this
     */
    public function setNovalidate($novalidate);

    /**
     * @param $enctype
     * @return $this
     */
    public function setEnctype($enctype);

    /**
     * @param $target
     * @return $this
     */
    public function setTarget($target);

    /**
     * @param $accept
     * @return $this
     */
    public function setAccept($accept);

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method);

    /**
     * Validate if the values of the fields are correct (type, length and format)
     * @return boolean
     */
    public function validate();

    /**
     * Fill the values of the fields with the data that comes from the post and get methods
     * @return $this
     */
    public function loadDataFromRequest();
}