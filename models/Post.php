<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Post extends ActiveRecord
{
    const ALLOWED_HTML_TAGS = ['b', 'i', 's'];
    const EDIT_TIME_LIMIT = 12 * 3600;
    const DELETE_TIME_LIMIT = 14 * 24 * 3600;
    const POST_COOLDOWN = 180;

    public static function tableName()
    {
        return '{{%posts}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string', 'min' => 5, 'max' => 1000],
            [['message'], 'filter', 'filter' => 'trim'],
            [['message'], 'filter', 'filter' => function ($value) {
                return $this->sanitizeHtml($value);
            }],
            [['message'], 'validateNotEmpty'],
            [['user_id', 'author_ip'], 'safe'],
        ];
    }

    public function validateNotEmpty($attribute, $params)
    {
        $cleanText = strip_tags($this->$attribute);
        $cleanText = trim($cleanText);
        
        if (empty($cleanText)) {
            $this->addError($attribute, 'Сообщение не может состоять только из пробелов или HTML-тегов.');
        }
    }

    protected function sanitizeHtml($html)
    {
        $allowedTags = '<b><i><s>';
        $cleanHtml = strip_tags($html, $allowedTags);
        $cleanHtml = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/', '', $cleanHtml);
        return $cleanHtml;
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Сообщение',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function canEdit()
    {
        return (time() - $this->created_at) <= self::EDIT_TIME_LIMIT;
    }

    public function canDelete()
    {
        return (time() - $this->created_at) <= self::DELETE_TIME_LIMIT;
    }

    public function softDelete()
    {
        $this->deleted_at = time();
        return $this->save(false, ['deleted_at']);
    }

    public static function canPostFromUser($userId)
    {
        $lastPost = self::find()
            ->where(['user_id' => $userId])
            ->andWhere(['deleted_at' => null])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if (!$lastPost) {
            return true;
        }

        return (time() - $lastPost->created_at) >= self::POST_COOLDOWN;
    }

    public static function getNextPostTimeForUser($userId)
    {
        $lastPost = self::find()
            ->where(['user_id' => $userId])
            ->andWhere(['deleted_at' => null])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if (!$lastPost) {
            return time();
        }

        return $lastPost->created_at + self::POST_COOLDOWN;
    }


    public static function getPostsCountByIp($ip)
    {
        return self::find()
            ->where(['author_ip' => $ip])
            ->andWhere(['deleted_at' => null])
            ->count();
    }


    public function getAuthorPostsCount()
    {
        return self::find()
            ->where(['author_ip' => $this->author_ip])
            ->andWhere(['deleted_at' => null])
            ->count();
    }
}