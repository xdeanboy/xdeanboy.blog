<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Models\ActiveRecordEntity;

class BlogImages extends ActiveRecordEntity
{
    protected $link;

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    protected static function getTableName(): string
    {
        return 'blog_images';
    }
}