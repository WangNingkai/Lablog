<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Comment;

class ValidateComment implements Rule
{
    private $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // 过滤无意义评论
        if (ctype_alnum($value) || in_array($value, ['test', '测试']) || has_filter($value)) {
            $this->message = '禁止使用无意义、非法词汇评论';
            return false;
        }
        $commentIp = request()->ip();;
        // 获取IP最近一次评论时间
        $lastCommentDate = Comment::query()->where('ip', $commentIp)
            ->orderBy('created_at', 'desc')
            ->value('created_at');
        $lastCommentTime = strtotime($lastCommentDate);
        // 限制1分钟内只许评论1次
        $time = time();
        if ($time-$lastCommentTime < 60) {
            $this->message = '评论太过频繁,请稍后再试.';
            return false;
        }
        // 限制同一IP一天评论数
        $date = date('Y-m-d', $time);
        $count = Comment::query()->where('ip', $commentIp)
            ->whereBetween('created_at', [$date.' 00:00:00', $date.' 23:59:59'])
            ->count();
        if ($count > 10) {
            $this->message = '今天已经评论太多了，明天再来吧.';
            return false;
        }

        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
