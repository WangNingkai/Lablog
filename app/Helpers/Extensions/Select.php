<?php

namespace App\Helpers\Extensions;

/**
 * 获取树形菜单
 * Class Select
 * @package App\Helpers\Extensions
 */
class Select
{
    /**
     * @var array 生成树型结构数组
     */
    public $arr;
    /**
     * @var array 生成树型结构所需修饰符号，可以换成图片
     */
    public $icon = [
        '│',
        '├─ ',
        '└─ '
    ];

    /**
     * @var string id字段
     */
    public $id = 'id';

    /**
     * @var string 父id字段
     */
    public $parent_id = 'parent_id';

    /**
     * @var string name字段
     */
    public $name = 'name';

    /**
     * 初始化
     * @param array $arr
     */
    public function __construct($arr)
    {
        $this->arr = $arr;
    }

    /**
     * 初始化父子
     *
     * @return array
     */
    public function make_tree()
    {
        return $this->init_tree($this->arr);
    }

    /**
     * 加前缀
     *
     * @return array
     */
    public function make_tree_with_prefix()
    {
        $res = $this->make_tree();
        return $this->add_prefix($res);
    }

    /**
     * 生成<option></option>
     *
     * @param integer $selected_id
     * @return string
     */
    public function make_option_tree_for_select($selected_id)
    {
        $res = $this->make_tree_with_prefix();
        return $this->make_options($res, $selected_id);
    }

    /**
     * 初始化父子树
     *
     * @param array $arr
     * @param int $parent_id
     * @return array
     */
    public function init_tree($arr, $parent_id = 0)
    {
        $new_arr = [];
        foreach ($arr as $k => $v) {
            if ($v[$this->parent_id] == $parent_id) {
                $new_arr[] = $v;
                unset($arr[$k]);
            }
        }
        foreach ($new_arr as &$a) {
            $a['children'] = $this->init_tree($arr, $a[$this->id]);
        }
        return $new_arr;
    }

    /**
     * 树形父子加前缀
     *
     * @param array $arr
     * @param string $prefix
     * @return array
     */
    public function add_prefix($arr, $prefix = '')
    {
        $new_arr = [];
        foreach ($arr as $v) {
            if ($prefix) {
                if ($v == end($arr)) {
                    $v[$this->name] = $prefix . $this->icon[2] . $v[$this->name];
                } else {
                    $v[$this->name] = $prefix . $this->icon[1] . $v[$this->name];
                }
            }

            if ($prefix == '') {
                $prefix_for_children = '　 ';
            } else {
                if ($v == end($arr)) {
                    $prefix_for_children = $prefix . '　　 ';
                } else {
                    $prefix_for_children = $prefix . $this->icon[0] . '　 ';
                }
            }
            $v['children'] = $this->add_prefix($v['children'], $prefix_for_children);

            $new_arr[] = $v;
        }
        return $new_arr;
    }

    /**
     * 生成option
     *
     * @param array $arr
     * @param integer $selected_id
     * @param integer $depth
     * @param integer $recursion_count
     * @param string $ancestor_ids
     * @return string
     */
    public function make_options($arr, $selected_id = 0, $depth = 0, $recursion_count = 0, $ancestor_ids = '')
    {
        $recursion_count++;
        $str = '';
        foreach ($arr as $v) {
            $selected = ($v[$this->id] == $selected_id) ? 'selected' : '';
            $str .= "<option value='{$v[$this->id]}' data-depth='{$recursion_count}' data-ancestor_ids='" . ltrim($ancestor_ids, ',') . "' {$selected} >{$v[$this->name]}</option>" . PHP_EOL;
            if ($v[$this->parent_id] == 0) {
                $recursion_count = 1;
            }
            if ($depth == 0 || $recursion_count < $depth) {
                $str .= $this->make_options($v['children'], $selected_id, $depth, $recursion_count, $ancestor_ids . ',' . $v[$this->id]);
            }

        }
        return $str;
    }

    /**
     * 获得祖先链
     *
     * @param array $arr
     * @param array $e
     * @return array
     */
    public function get_ancestors($arr, $e)
    {
        $ancestors = array();
        foreach ($arr as $a) {
            if ($a[$this->id] == $e[$this->parent_id]) {
                $ancestors[] = $a;
                if ($a[$this->parent_id] != 0) {
                    $ancestors = array_merge($this->get_ancestors($arr, $a), $ancestors);
                }
            }
        }
        return $ancestors;
    }
}

