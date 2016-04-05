<?php

class Helper {
    static public function getUsedAreas($items) {
        $result = [];
        
        foreach ($items as $item) {
            if (!empty($item['headings'])) {
                foreach ($item['headings'] as $area) {
                    if (is_array($area)) {
                        $result[] = $area['heading'];
                    } else {
                        $result[] = $area;
                    }
                }
            } else if (!empty($item['heading'])) {
                if (is_array($item['heading'])) {
                    $result[] = $item['heading']['heading'];
                } else {
                    $result[] = $item['heading'];
                }
            }
        }
        
        return array_unique($result);
    }
    
    static public function generateSelectOptions($values, $captions = null, $selected = null) {
        if (!is_array($captions)) {
            if ($selected) {
                $captions = null;
            } else {
                $selected = $captions;
            }
        }
        
        $result = '';

        foreach ($values as $key => $value) {
            $result .= '<option';

            if ($selected == $value) {
                $result .= ' selected';
            }

            $result .= ' value="' . $value . '">';
            
            if (array_key_exists($key, $captions)) {
                $result .= $captions[$key];
            } else {
                $result .= $value;
            }
            
            $result .= '</option>';
        }

        return $result;
    }
    
    static public function formatDate($format, $time = null) {
        if (!$time) {
            $time = time();
        } else if (is_string($time)) {
            $time = strtotime($time);
        }
        
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
        }
        
        if (strpos($format, '%q') !== false) {
            $month_num = date('n', $time);
            $month_name = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
            $format = str_replace('%q', $month_name[$month_num - 1], $format);
        }
        
        $is_cp1251 = explode('.', setlocale(LC_ALL, 0))[1] == '1251';
        
        if ($is_cp1251) {
            $format = iconv('UTF-8', 'CP1251', $format);
        }
        
        $result = strftime($format, $time);
        
        if ($is_cp1251) {
            $result = iconv('CP1251', 'UTF-8', $result);
        }
        
        return $result;
    }
    
    static public function resolveRelations($values, $relations, $relations_key = null) {
        if (empty($values)) {
            return [];
        }


        if ($relations_key)
        {
            //error in php 5.4
            $relations = array_column($relations, $relations_key);
        } else if (!is_array($relations)) {
            $relations = [$relations];
        }
        
        $result = array_filter($values, function($value) use ($relations) {
            return in_array($value['id'], $relations);
        });
        
        return array_values($result);
    }
    
    static public function getPostSubjects($post, $subjects) {
        if (empty($post['subjects'])) {
            return null;
        }
        
        $areas = [];
        foreach ($post['subjects'] as $post_subject) {
            foreach ($subjects as $subject) {
                if ($subject['id'] == $post_subject['subject']) {
                    $areas[] = $subject;
                }
            }
        }
        
        return $areas;
    }
    
    static public function truncateString($input, $length = 500, $extra_text = '') {
        if (empty($input) || strlen($input) <= $length) {
            return $input;
        }
        
        $output = substr($input, 0, $length);
        $pos = 0 ;
        $found = false;
        
        for ($i = $length - 1; $i >= 0 ; $i--) {
            if (ctype_space($output[$i])) {
                $found = true;
                break;
            }
             
            $pos++;
        }
        
        if ($found && ($pos > 0)) {
            $output = rtrim(substr($output, 0, ($length - $pos)));
        }
        
        $output .= $extra_text;
        return $output;
    }
    
    static public function avatarUrl($file, $size = 50) {
        return ($file) ? '/image/zoom2/' . $size . 'x' . $size . '/upload/' . $file : '/img/missing-avatar.png';
    }
}