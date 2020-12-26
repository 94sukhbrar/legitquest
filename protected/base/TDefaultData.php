<?php

/**
 *
 *@copyright :Amusoftech Pvt. Ltd. < www.amusoftech.com >
*@author     : Ram mohamad Singh< er.amudeep@gmail.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 */
namespace app\base;

use app\models\User;
use app\modules\blog\models\Category;
use app\modules\blog\models\Post;

class TDefaultData
{

    public static function data()
    {
        User::log(__FUNCTION__);
        Category::addData([
            [
                'title' => 'Category One',
                'type_id' => 1
            ],
            
            [
                'title' => 'Category Two',
                'type_id' => 2
            ]
            
        ]);
        
        Post::addData([
            [
                'title' => 'Example',
                'type_id' => 1
            ]
        ]);
      
        
        User::log(__FUNCTION__ . "End");
    }
}

