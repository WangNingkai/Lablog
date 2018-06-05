<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Base
{
    use SoftDeletes;

    /**
     * 添加文章
     *
     * @param array $data
     * @return bool|mixed
     */
    public function storeData($data)
    {
        // 如果没有描述;则截取文章内容的前200字作为描述
        if (empty($data['description'])) {
            $description = preg_replace(array('/[~*>#-]*/', '/!?\[.*\]\(.*\)/', '/\[.*\]/'), '', $data['content']);
            $data['description'] = re_substr($description, 0, 150, true);
        }

        // markdown转html
        unset($data['editormd_id-html-code']);
        $data['html'] = markdown_to_html($data['content']);
        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);
        //添加数据
        $result = parent::storeData($data);
        baidu_push($result);
        if ($result) {
            show_message('添加成功');
            // 给文章添加标签
            $articleTag = new ArticleTag();
            $articleTag->addTagIds($result, $tag_ids);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 后台文章列表
     *
     * @return mixed
     */
    public function getAdminList()
    {
        $data = $this
            ->select('articles.*', 'c.name as category_name')
            ->join('categories as c', 'articles.category_id', 'c.id')
            ->orderBy('created_at', 'desc')
            // ->withTrashed()
            ->get();
        return $data;
    }

    /**
     * 获取前台文章列表
     *
     * @return mixed
     */
    public function getHomeList($map = [])
    {
        // 获取文章分页
        $data = $this
            ->whereMap($map)
            ->select('articles.id', 'articles.title', 'articles.author', 'articles.keywords', 'articles.description', 'articles.category_id', 'articles.created_at', 'articles.updated_at', 'articles.click', 'c.name as category_name')
            ->join('categories as c', 'articles.category_id', 'c.id')
            ->orderBy('articles.created_at', 'desc')
            ->simplePaginate(6);
        // 提取文章id组成一个数组
        $dataArray = $data->toArray();
        $article_id = array_column($dataArray['data'], 'id');
        // 传递文章id数组获取标签数据
        $articleTagModel = new ArticleTag;
        $tag = $articleTagModel->getTagNameByArticleIds($article_id);
        foreach ($data as $k => $v) {
            $data[$k]->tag = isset($tag[$v->id]) ? $tag[$v->id] : [];
        }
        return $data;
    }

    /**
     * 通过文章id获取数据
     *
     * @param $id
     * @return mixed
     */
    public function getDataById($id)
    {
        $data = $this->select('articles.*', 'c.name as category_name')
            ->join('categories as c', 'articles.category_id', 'c.id')
            ->where('articles.id', $id)
            ->withTrashed()
            ->first();
        $articleTag = new ArticleTag;
        $tag = $articleTag->getTagNameByArticleIds([$id]);
        // 处理标签可能为空的情况
        $data['tag'] = empty($tag) ? [] : current($tag);
        return $data;
    }
}
