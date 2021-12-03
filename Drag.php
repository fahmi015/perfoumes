<?php

namespace App\Libraries;
use DB;
use App\Models\Category;

class Drag
{

    static private function recur1($nested_array=[], &$simplified_list=[]){
        $_this = new self;
        static $counter = 0;
        
        foreach($nested_array as $k => $v){
            
            $sort_order = $k+1;
            $simplified_list[] = [
                "id" => $v['id'], 
                "parent_id" => 0, 
                "sort_order" => $sort_order
            ];
            
            if(!empty($v["children"])){
                $counter+=1;
                $_this->recur2($v['children'], $simplified_list, $v['id']);
            }

        }
    }

    static private function recur2($sub_nested_array=[], &$simplified_list=[], $parent_id = NULL){
        $_this = new self;
        static $counter = 0;

        foreach($sub_nested_array as $k => $v){
            
            $sort_order = $k+1;
            $simplified_list[] = [
                "id" => $v['id'], 
                "parent_id" => $parent_id, 
                "sort_order" => $sort_order
            ];
            
            if(!empty($v["children"])){
                $counter+=1;
                return $_this->recur2($v['children'], $simplified_list, $v['id']);
            }
        }
    }
    
    static public function save($request){
        $_this = new self;

        $json = $request->nested_category_array;
        $decoded_json = json_decode($json, TRUE);

        $simplified_list = [];
        $_this->recur1($decoded_json, $simplified_list);

        DB::beginTransaction();
        try {
            $info = [
                "success" => FALSE,
            ];

            foreach($simplified_list as $k => $v){
                $category = Category::find($v['id']);
                $category->fill([
                    "parent_id" => $v['parent_id'],
                    "sort_order" => $v['sort_order'],
                ]);

                $category->save();
            }

            DB::commit();
            $info['success'] = TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            $info['success'] = FALSE;
        }
        return redirect()->back()->withSuccessMessage('Added Successfully');

    }

}


