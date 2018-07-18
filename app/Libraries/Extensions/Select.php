<?php
 namespace App\Libraries\Extensions;

class Select
{

    public function make_tree($arr){
        return $this->init_tree($arr);
    }

    public function make_tree_with_prefix($arr)
    {
        $arr = $this->make_tree($arr);
        return $this->add_prefix($arr);
    }

    /**
     * @param $arr
     * @param int $depth 当$depth为0的时候表示不限制深度
     * @return string
     */
    public function make_option_tree_for_select($arr, $depth=0)
    {
        $arr = $this->make_tree_with_prefix($arr);
        return $this->make_options($arr, $depth);
    }



    public function init_tree($arr, $parent_id = 0){
        $new_arr = [];
        foreach($arr as $k=>$v){
            if($v->parent_id == $parent_id){
                $new_arr[] = $v;
                unset($arr[$k]);
            }
        }
        foreach($new_arr as &$a){
            $a->children = $this->init_tree($arr, $a->id);
        }
        return $new_arr;
    }



    public function add_prefix($arr, $prefix = '') {
        $new_arr = [];
        foreach ($arr as $v) {
            if ($prefix) {
                if ($v == end($arr)) {
                    $v->name = $prefix.'└─ '.$v->name;
                } else {
                    $v->name = $prefix.'├─ '.$v->name;
                }
            }

            if ($prefix == '') {
                $prefix_for_children = '　 ';
            } else {
                if ($v == end($arr)) {
                    $prefix_for_children = $prefix.'　　 ';
                } else {
                    $prefix_for_children = $prefix.'│　 ';
                }
            }
            $v->children = $this->add_prefix($v->children, $prefix_for_children);

            $new_arr[] = $v;
        }
        return $new_arr;
    }

    public function make_options($arr, $depth, $recursion_count = 0, $ancestor_ids = '') {
        $recursion_count++;
        $str = '';
        foreach ($arr as $v) {
            $str .= "<option value='{$v->id}' data-depth='{$recursion_count}' data-ancestor_ids='".ltrim($ancestor_ids,',')."'>{$v->name}</option>";
            if ($v->parent_id == 0) {
                $recursion_count = 1;
            }
            if ($depth==0 || $recursion_count<$depth) {
                $str .= $this->make_options($v->children, $depth, $recursion_count, $ancestor_ids.','.$v->id);
            }

        }
        return $str;
    }
}

