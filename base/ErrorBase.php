<?php


namespace formGenereitor\base;


abstract class ErrorBase
{
    const LANGUAGE_ES = 'es';
    const LANGUAGE_EN = 'en';
    const ERRORS = [
        self::LANGUAGE_ES => self::ERRORS_ES,
        self::LANGUAGE_EN => self::ERRORS_EN,
    ];

    const ERRORS_ES = [
        'required' => 'Campo obligario',
        'min' => 'El valor debe ser mayor o igual que %s',
        'max' => 'El valor debe ser menor o igual que %s',
        'minlegth' => 'Debe superar los %s caracteres',
        'maxlength' => 'No debe superar los %s caracteres',
        'pattern' => 'No sigue el patrón %s',
    ];

    const ERRORS_EN = [
        'required' => 'Required field ',
        'min' => 'The value must be greater than or equal to %s',
        'max' => 'The value must not be greater than or equal to %s',
        'minlegth' => 'Must exceed %s characters',
        'maxlength' => 'Must not exceed %s characters',
        'pattern' => 'Does not follow the pattern %s',
    ];

    /**
     * @param string $error
     * @param string $value
     * @param string $language
     * @return string
     * @throws \Exception
     */
    public static function getError(string $error, $value = '', $language = 'en')
    {
        if(!isset(self::ERRORS[$language]) or !isset(self::ERRORS[$language][$error])){
            throw new \Exception("The error [{$language}][{$error}] is not defined");
        }

        return sprintf(self::ERRORS[$language][$error], $value);
    }
}