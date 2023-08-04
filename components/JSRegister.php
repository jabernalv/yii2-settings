<?php

namespace jabernal\settings\components;

use yii\base\Widget;
use yii\web\View;

/**
 * Widget para registrar scripts desde archivos de vista.
 *
 * Este widget permite obtener el script interno del widget y registrarlo mediante \yii\web\View::registerJs()
 */
class JSRegister extends Widget {
    // Variables a pasar a \yii\base\View::registerScript()
    public $key;
    public $position;

    /**
     * Inicia el widget llamando a ob_start(), almacenando el resultado en el buffer de salida.
     * @see \yii\base\Widget::begin()
     *
     * @param array $config La configuración del widget.
     * @return JSRegister El objeto del widget JSRegister.
     */
    public static function begin($config = []) {
        $widget = parent::begin($config);

        // Verifica si se proporcionó una posición válida, de lo contrario, utiliza View::POS_READY por defecto
        $widget->position = isset($config['position']) && self::isValidPosition($config['position'])
            ? $config['position']
            : View::POS_READY;

        // Verifica si se proporcionó una clave válida, de lo contrario, utiliza null
        $widget->key = isset($config['key']) && is_string($config['key'])
            ? $config['key']
            : null;

        ob_start();

        return $widget;
    }


    /**
     * Obtiene el script desde el buffer de salida y lo registra mediante \yii\web\View::registerJs()
     * @see \yii\base\Widget::end()
     */
    public static function end() {
        $script = ob_get_clean();
        $widget = parent::end();

        // Extrae el script del buffer de salida
        if (preg_match("/^\\s*\\<script\\>(.*)\\<\\/script\\>\\s*$/s", $script, $matches)) {
            $script = $matches[1];
        }

        // Registra el script en la vista
        $widget->view->registerJs($script, $widget->position, $widget->key);
    }

    /**
     * Verifica si una posición es válida.
     *
     * @param string $position La posición a verificar.
     * @return bool true si la posición es válida, false en caso contrario.
     */
    protected static function isValidPosition($position) {
        return in_array($position, [View::POS_HEAD, View::POS_BEGIN, View::POS_END, View::POS_READY, View::POS_LOAD]);
    }
}
