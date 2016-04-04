<?php

namespace common\components;

use app\models\Posts;
use app\models\Comments;

use common\components\UserService;

class PostsService
{
    public static function getPosts()
    {
        $data    = Posts::find()->orderBy(['date' => SORT_DESC])->all();
        $counter = 0;
        foreach ($data as $row)
        {
            $refined_data[$counter]['id']              = $row['id'];
            $refined_data[$counter]['author']          = UserService::getName($row['author']);
            $refined_data[$counter]['post_date']       = $row['date'];
            $refined_data[$counter]['post_text']       = $row['text'];
            $refined_data[$counter]['title']           = $row['title'];
            //$refined_data[$counter]['comments']        = PostsService::getComments($row['post_id']);
            $counter++;
        }

        return isset($refined_data) ? $refined_data : [];
    }

    public static function addPost($author, $date, $title, $text)
    {
        $post = new Posts();
        $post->author = $author;
        $post->date = $date;
        $post->title = $title;
        $post->text = $text;
        return $post->save();
    }
    
    public static function editPost($id, $title, $text)
    {
        $post = Posts::findOne($id);
        $post->title = $title;
        $post->text = $text;
        return $post->save();
    }
    
    public static function removePost($id)
    {
        $post = new Posts();
        return $post->deleteAll(['id'=>$id]);
    }
    
    public static function addComment($post_id,$comment_author,$comment_text,$anonymous_author,$anonymous_author_name)
    {
        $comment = new Comments();
        $comment->post_id = (int)$post_id;
        $comment->comment_text = $comment_text;
        if($anonymous_author == false)
        {
            $comment->anonymous_author = 0;
            $comment->comment_author = $comment_author;
            $comment->anonymous_author_name = "Stefan";
        }
        else if($anonymous_author == true)
        {
            $comment->anonymous_author = 1;
            $comment->anonymous_author_name = $anonymous_author_name;
        }
        return $comment->save();
    }
    
    public static function getComments($post_id)
    {
        $data    = Comments::find()->where(['post_id' => $post_id])->all();
        $counter = 0;
        foreach ($data as $row)
        {
            if ($row['anonymous_author'] == 0)
            {
                $refined_data[$counter]['username'] = UserService::getName($row['comment_author']);
                $refined_data[$counter]['guest'] = 0;
                $refined_data[$counter]['avatar'] = UserService::getAvatar($row['comment_author']);
            }
            else
            {
                $refined_data[$counter]['username'] = $row['anonymous_author_name'];
                $refined_data[$counter]['guest'] = 1;
            }
            $refined_data[$counter]['text'] = $row['comment_text'];
            $counter++;
        }

        return isset($refined_data) ? $refined_data : [];
    }
}
