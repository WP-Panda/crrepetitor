<?php
/**
 * Класс для удобного получения данных из базы WordPress
 * @author Максим (WP_Panda) Попов <yoowordpress@yandex.ru>
 * @copyright  2012-2015 WP_Panda
 * @version 1.0.1
 */

class Cr_Filter_Class {

    /**
     * Префикс таблиц базы данных
     * @access private
     * @var
     */
    var $prefix;

    /**
     * Доступ в класс wpdb
     * @access private
     * @var
     */
    var $base;

    public function __construct() {
        global $wpdb;
        $this->prefix = $wpdb->prefix;
        $this->base = $wpdb;
    }

    /**
     * Выборка из базы данных
     * @param array $array {
     *      @type array $param      Массив для полей для выборки где ключ - имя поля, значение - значение поля
     *      @type array $field      Массив определяющий какие поля получать, имена полей через запятую, если массив содержит * будут получены все поля независимо от наличия других элементов
     *      @type string            Имя таблицы из которой получать поля (Внимание!!! Превикс таблицы вводить не надо)
     *      @type bool|null         Прараметр для просмотра запроса на этапе разработке, если установить в true функция вернет запрос, false - результат запроса, по умолчанию false
     *      @type string order_by   По какому полю сортировать запрос
     *       /////////////////////////////////////////////////
     *          Заметка для меня, ниже надо добавить RAND()
     *       ////////////////////////////////////////////////
     *      @type string order      Направление сортировки  Может быть 'ASC', 'DESC',
     * }
     *
     * @return mixed
     */

    function get_sphinx_result($array) {

        $table = $this->prefix . $array['table'];

        $n=0;
        $inquiry ='';
        if( !empty($array['param']) ) {

            foreach ($array['param'] as $key => $val) {
                $pref = $n === 0 ? ' WHERE ' : ' AND ';
                if(is_array($val) ) {
                    $one_val ='';
                    foreach($val as $one){
                        $one_val .= $one .',';
                    }
                    $one_val = trim($one_val,',');
                    $inquiry .= $pref . " `" . $key . "` IN (" . esc_sql($one_val) . ")";
                } else {
                    $inquiry .= $pref . " `" . $key . "`='" . esc_sql($val) . "'";
                    $n++;
                }
            }
        }

        if( ! array_key_exists('field',$array) || in_array('*',$array['field']) ){
            $fields = '*';
        } else {
            $fields = '';
            $n=0;
            foreach ($array['field'] as $key) {
                $separator = $n > 0 ? ',' : '';
                $fields .= $separator . "`" . esc_sql($key). "`";
                $n++;
            }
        }

        $order ='';
        if ( ! empty($array['order']) && ! empty($array['order_by'] ) ) {
            $order = " ORDER BY `" . $table . "`.`" . $array['order_by'] . "`" . esc_sql($array['order']);
        }

        if ( ! empty($array['order2']) && ! empty($array['order_by2'] ) ) {
            $order .= " ,`" .$array['order_by2'] . "`" . esc_sql($array['order2']);
        }

        $limit = '';
        if ( ! empty($array['limit'] ) ) {
            $offset = ( ! empty( $array['offset'] ) ) ? esc_sql((int)$array['offset']) : 0 ;
            $count = esc_sql((int)$array['limit']);
            $limit = " LIMIT" . $offset .','. $count;
        }

        $sql = "SELECT " . $fields . " FROM `" . $table . "` " . $inquiry . $order . $limit;

        if($array['debug'] === true )
            die($sql);
        $result = $this->base->get_results($sql);

        return $result;
    }

    /**
     * Получение уникальных значений полей
     * @param array $array - смотреть get_sphinx_result()
     * @param array|null $name - поля для вывода через запятую, по умолчанию будут взяты поля из параметра field параметра $array
     * @return array
     */
    function get_sphinx_unique_vals($array,$name=null){

        $result = $this->get_sphinx_result($array);
        $arrays = array();
        $name = $name ? $name : $array['field'];
        foreach ($name as $one) {
            foreach ($result as $val) {
                $arrays[$one][] = str_replace('﻿', '', trim($val->$one));
            }
            # asort() - убрать он только длля карбон про
            $arrays[$one] = array_unique($arrays[$one]);
            asort($arrays[$one]);
            reset($arrays[$one]);
        }

        return $arrays;
    }

    /**
     * @param $name - поле значенте которого надо получить
     * @param $param - смотреть get_sphinx_result()
     * @param $fields - смотреть get_sphinx_result()
     * @param $table - смотреть get_sphinx_result()
     * @param $code - html код вывода элемента
     * @param null $before - html код вывода до элемента
     * @param null $after - html код вывода после элемента
     * @param null $debug - смотреть get_sphinx_result()
     * @return null|string
     */
    function get_code_sphinx_result($array,$name,$code,$before=null,$after=null){
        $array['name'] = array($array['name']);
        $result = $this->get_sphinx_unique_vals($array,$name);
        //cr_array($result);
        $out = $before;
        foreach ($result[$name] as $key)
            $out .=str_replace('%val%',$key,$code);
        $out .=$after;
        return $out;
    }
}