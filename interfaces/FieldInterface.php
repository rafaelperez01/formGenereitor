<?php

namespace formGenereitor\interfaces;

/**
 * @author Rafael Perez <rafaelperez7461@gmail.com>
 * Displays <a href="https://opensource.org/licenses/MIT">The MIT License</a>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @package formGenereitor1.0.0
 */
interface FieldInterface
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
     * If an attribute exists, it gets the value.
     *
     * @param string $attrName
     * @return mixed
     */
    public function get(string $attrName);

    /**
     * @param string $attrName
     * @param $value
     * @return $this
     */
    public function set(string $attrName, $value);

    /**
     * Set the field type, validating that the type is one allowed within the FIELD_TYPES_LIST list
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type);

    /**
     * @return string
     */
    public function render();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * It receives as the first parameter an associative array with the key = value pair
     * @param array $options
     * @param null $selected
     * @return $this
     */
    public function setOptions(array $options, $selected = null);

    /**
     * @param bool $show
     * @return $this
     */
    public function showLabel($show = true);

    /**
     * @param bool $show
     * @return $this
     */
    public function showBootstrap($show = true);

    /**
     * @return false|string
     */
    public function toJson();

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return mixed|string
     */
    public function getLabel();

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * @return mixed
     */
    public function getLabelId();

    /**
     * @param string $id
     * @return $this
     */
    public function setLabelId(string $id);

    /**
     * @return mixed
     */
    public function getLabelFor();

    /**
     * @param string $for
     * @return $this
     */
    public function setLabelFor(string $for);

    /**
     * @return mixed
     */
    public function getLabelClass();

    /**
     * @param string $class
     * @return $this
     */
    public function setLabelClass(string $class);

    /**
     * @return mixed
     */
    public function getLabelForm();

    /**
     * @param string $form
     * @return $this
     */
    public function setLabelForm(string $form);

    /**
     * @return mixed
     */
    public function getLabelAccesskey();

    /**
     * @param string $accesskey
     * @return $this
     */
    public function setLabelAccesskey(string $accesskey);

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @return array
     */
    public function getLabelAttributes();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getType();

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
    public function getValue();

    /**
     * @return mixed
     */
    public function getAlt();

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @return mixed
     */
    public function getPlaceholder();

    /**
     * @return mixed
     */
    public function getRequired();

    /**
     * @return mixed
     */
    public function getFormTarget();

    /**
     * @return mixed
     */
    public function getMaxlength();

    /**
     * @return mixed
     */
    public function getMinlength();

    /**
     * @return mixed
     */
    public function getMax();

    /**
     * @return mixed
     */
    public function getMin();

    /**
     * @return mixed
     */
    public function getRows();

    /**
     * @return mixed
     */
    public function getCols();

    /**
     * @return mixed
     */
    public function getWidth();

    /**
     * @return mixed
     */
    public function getHeight();

    /**
     * @return mixed
     */
    public function getDisabled();

    /**
     * @return mixed
     */
    public function getReadonly();

    /**
     * @return mixed
     */
    public function getAutofocus();

    /**
     * @return mixed
     */
    public function getAutocomplete();

    /**
     * @return mixed
     */
    public function getSelected();

    /**
     * @return mixed
     */
    public function getChecked();

    /**
     * @return mixed
     */
    public function getMultiple();

    /**
     * @return mixed
     */
    public function getStep();

    /**
     * @return mixed
     */
    public function getSize();

    /**
     * @return mixed
     */
    public function getSrc();

    /**
     * @return mixed
     */
    public function getPattern();

    /**
     * @return mixed
     */
    public function getAccept();

    /**
     * @return mixed
     */
    public function getWrap();

    /**
     * @return mixed
     */
    public function getStyle();

    /**
     * @param string $style
     * @return $this
     */
    public function setStyle(string $style);

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * @param string $class
     * @return $this
     */
    public function setClass(string $class);

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value);

    /**
     * @param string $alt
     * @return $this
     */
    public function setAlt(string $alt);

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder(string $placeholder);

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired($required = true);

    /**
     *
     * @param string $formId
     * @return $this
     */
    public function setFormTarget(string $formId);

    /**
     * @param $maxlength
     * @return $this
     */
    public function setMaxlength($maxlength);

    /**
     * @param $minlength
     * @return $this
     */
    public function setMinlength($minlength);

    /**
     * @param $max
     * @return $this
     */
    public function setMax($max);

    /**
     * @param $min
     * @return $this
     */
    public function setMin($min);

    /**
     * @param $rows
     * @return $this
     */
    public function setRows($rows);

    /**
     * @param $cols
     * @return $this
     */
    public function setCols($cols);

    /**
     * @param $width
     * @return $this
     */
    public function setWidth($width);

    /**
     * @param $height
     * @return $this
     */
    public function setHeight($height);

    /**
     * @param bool $disabled
     * @return $this
     */
    public function setDisabled($disabled = true);

    /**
     * @param bool $readonly
     * @return $this
     */
    public function setReadonly($readonly = true);

    /**
     * @param bool $autofocus
     * @return $this
     */
    public function setAutofocus($autofocus = true);

    /**
     * @param bool $autocomplete
     * @return $this
     */
    public function setAutocomplete($autocomplete = true);

    /**
     * @param bool $selected
     * @return $this
     */
    public function setSelected($selected = true);

    /**
     * @param bool $checked
     * @return $this
     */
    public function setChecked($checked = true);

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true);

    /**
     * @param $step
     * @return $this
     */
    public function setStep($step);

    /**
     * @param $size
     * @return $this
     */
    public function setSize($size);

    /**
     * @param $src
     * @return $this
     */
    public function setSrc($src);

    /**
     * The pattern must always be indicated between delimiters
     * ej: /[A-Z]/ in this case, the delimiters are the bars (/)
     * https://www.php.net/manual/es/regexp.reference.delimiters.php
     * @param string type $pattern
     * @return $this
     */
    public function setPattern($pattern);

    /**
     * @param $accept
     * @return $this
     */
    public function setAccept($accept);

    /**
     * @param $wrap
     * @return $this
     */
    public function setWrap($wrap);

    /**
     * @param array $constraint
     */
    public function setConstraint(array $constraint);

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
     * @return bool
     * @throws \Exception
     */
    public function validate();
}