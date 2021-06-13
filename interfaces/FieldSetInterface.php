<?php

namespace formGenereitor\interfaces;

/**
 * @author Rafael Perez <rafaelperez7461@gmail.com>
 * Displays <a href="https://opensource.org/licenses/MIT">The MIT License</a>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @package formGenereitor1.0.0
 */
interface FieldSetInterface
{
    /**
     * If an attribute exists, it gets the value.
     *
     * @param string $attrName
     * @return string|null
     */
    public function get(string $attrName);

    /**
     *
     * @param string $attrName
     * @param $value
     * @return $this
     */
    public function set(string $attrName, $value);

    /**
     * @return FormInterface|null
     */
    public function getForm();

    /**
     * @param FormInterface $form
     * @return $this
     */
    public function setForm(FormInterface $form);

    /**
     * @return string
     */
    public function render();

    /**
     * @param $name
     * @param string $value
     * @param string $type
     * @return $this
     */
    public function addField($name, $value = "", $type = "");

    /**
     * @param FieldInterface $field
     * @return $this
     */
    public function addFieldObj(FieldInterface $field);

    /**
     * @return false|string
     */
    public function toJson();

    /**
     * @return array[]|null
     */
    public function toArray();

    /**
     * @return array[]
     */
    public function getAttributes();

    /**
     * @return array
     */
    public function getId();

    /**
     * @return array
     */
    public function getClass();

    /**
     * @return array
     */
    public function getFields();

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return array
     */
    public function getStyle();

    /**
     * @param $style
     * @return $this
     */
    public function setStyle($style);

    /**
     * @param $class
     * @return $this
     */
    public function setClass($class);

    /**
     * You can receive an array with the key-value pair to create or add fields from it,
     * or you can receive an array of objects of type FieldInterface and add them to the list of fields
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields);

    /**
     * @return string
     */
    public function getLegend();

    /**
     * @return bool
     */
    public function getReadOnly();

    /**
     * @param $legend
     * @return $this
     */
    public function setLegend($legend);

    /**
     * @param $readOnly
     * @return $this
     */
    public function setReadOnly($readOnly);

    /**
     * @param bool $show
     * @return $this
     */
    public function showFieldLabel($show = true);

    /**
     * @param bool $show
     * @return $this
     */
    public function showFieldBootstrap($show = true);
}