<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Models\ActiveRecordEntity;

class BlogSections extends ActiveRecordEntity
{
    protected $name;
    protected $image;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    protected static function getTableName(): string
    {
        return 'blog_sections';
    }


    public static function getSectionByName(string $name): ?self
    {
        $result = self::findOneByColumn('name', $name);

        return !empty($result) ? $result : null;
    }
}