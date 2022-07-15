<?php

namespace xdeanboy\Models\Blog;

use xdeanboy\Exceptions\ForbiddenException;
use xdeanboy\Exceptions\InvalidArgumentException;
use xdeanboy\Exceptions\NotFoundException;
use xdeanboy\Exceptions\UnauthorizedException;
use xdeanboy\Models\ActiveRecordEntity;

class Blog extends ActiveRecordEntity
{
    protected $imageId;
    protected $sectionId;
    protected $title;
    protected $text;
    protected $createdAt;

    /**
     * @param int $imageId
     */
    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return $this->imageId;
    }

    /**
     * @param string $linkImage
     * @return void
     */
    public function setImage(string $linkImage): void
    {
        $image = new BlogImages();
        $image->setLink($linkImage);
        $image->save();

        $this->setImageId($image->getId());
    }

    /**
     * @return BlogImages|null
     */
    public function getImage(): ?BlogImages
    {
        $checkImage = BlogImages::getById($this->getImageId());

        return !empty($checkImage) ? $checkImage : null;
    }

    /**
     * @param int $sectionId
     */
    public function setSectionId(int $sectionId): void
    {
        $this->sectionId = $sectionId;
    }

    /**
     * @param string $name
     * @return void
     * @throws InvalidArgumentException
     */
    public function setSection(string $name): void
    {
        $checkSection = BlogSections::getSectionByName($name);

        if ($checkSection === null) {
            throw new InvalidArgumentException('Розділ контенту не знайдено');
        }

        $this->sectionId = $checkSection->getId();
    }

    /**
     * @return int
     */
    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    /**
     * @return BlogSections|null
     */
    public function getSection(): ?BlogSections
    {
        $checkSection = BlogSections::getById($this->getSectionId());

        return !empty($checkSection) ? $checkSection : null;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getBeginningText(): string
    {
        return mb_substr($this->getText(), 0, 210);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getCreatedAtDate(): string
    {
        return date('Y-m-d', strtotime($this->getCreatedAt()));
    }

    public function getDifferenceCreated(): string
    {
        $differenceSecond = time()-strtotime($this->getCreatedAt());

        $minutes = floor($differenceSecond/60);
        $hours = floor($minutes/60);
        $days = floor($hours/24);
        $weeks = floor($days/7);


        if ($minutes < 60) {
            return $minutes . ' хв назад';
        } elseif ($hours < 24) {
            switch ($hours) {
                case 1:
                    return $hours . ' година назад';
                case 2 or 3 or 4:
                    return $hours . ' години назад';
                default:
                    return $hours . ' годин назад';
            }
        } elseif ($days < 7) {
            switch ($days) {
                case 1:
                    return $days . ' день назад';
                case 2 or 3 or 4:
                    return $days . ' дні назад';
                default:
                    return $days . ' днів назад';
            }
        } else {
            switch ($weeks) {
                case 1:
                    return $weeks . ' неділя назад';
                case 2 or 3 or 4:
                    return $weeks . ' неділі назад';
                default:
                    return $weeks . ' неділь назад';
            }
        }
    }

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'blog';
    }

    /**
     * @param array $postContent
     * @return static|null
     * @throws InvalidArgumentException
     */
    public static function add(array $postContent): self
    {
        if (empty($postContent['section'])) {
            throw new InvalidArgumentException('Виберіть розділ контенту');
        }

        if (empty(BlogSections::getSectionByName($postContent['section']))) {
            throw new InvalidArgumentException('Невідомий розділ контенту');
        }

        if (empty($postContent['image'])) {
            throw new InvalidArgumentException('Посилання на фото не може бути пустим');
        }

        if (empty($postContent['title'])) {
            throw new InvalidArgumentException('А де титулка до посту?');
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|a-zA-Z0-9]+$~',
            str_replace(' ', '', trim($postContent['title'])))) {
            throw new InvalidArgumentException(
                'Титулка посту може мати тільки англійські, українські літери та арабські цифри');
        }

        if (empty($postContent['text'])) {
            throw new InvalidArgumentException('Пост без тексту не може бути створеним');
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|\n\r\\s+a-zA-Z0-9]+$~',
            trim($postContent['text']))) {
            throw new InvalidArgumentException(
                'Текст посту може мати тільки англійські, українські літери та арабські цифри');
        }

        $post = new Blog();
        $post->setSection($postContent['section']);
        $post->setImage($postContent['image']);
        $post->setTitle($postContent['title']);
        $post->setText($postContent['text']);

        $post->save();

        return $post;
    }

    /**
     * @param string $sectionName
     * @return array
     * @throws InvalidArgumentException
     * @throws NotFoundException
     */
    public static function findAllBySection(string $sectionName): array
    {
        $checkSection = BlogSections::getSectionByName($sectionName);

        if ($checkSection === null) {
            throw new NotFoundException('Розділ ' . $sectionName . ' не знайдено');
        }

        $postsBySection = Blog::findAllByColumnOrdered('section_id', $checkSection->getId(), 'created_at');

        if ($postsBySection === null) {
            throw new InvalidArgumentException('Контенту за розділом ' . $sectionName . ' не знайдено');
        }

        return $postsBySection;
    }

    /**
     * @return array|null
     */
    public static function findAllBySortCreated(): ?array
    {
        $posts = Blog::findAllByDesc('created_at');

        return !empty($posts) ? $posts : null;
    }

    /**
     * @param array $dataPost
     * @return $this
     * @throws InvalidArgumentException
     */
    public function edit(array $dataPost): self
    {
        if (empty($dataPost['section'])) {
            throw new InvalidArgumentException('Виберіть розділ контенту');
        }

        if (BlogSections::getSectionByName($dataPost['section']) === null) {
            throw new InvalidArgumentException('Невідомий розділ контенту');
        }

        if (empty($dataPost['image'])) {
            throw new InvalidArgumentException('Пост має бути з фото');
        }

        if (empty($dataPost['title'])) {
            throw new InvalidArgumentException('Титулка посту не може бути пустою');
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|\n\r\\s+a-zA-Z0-9]+$~',
            trim($dataPost['title']))) {
            throw new InvalidArgumentException(
                'Титулка посту може мати тільки англійські, українські літери та арабські цифри');
        }

        if (empty($dataPost['text'])) {
            throw new InvalidArgumentException('Текст посту не може бути пустим');
        }

        if (!preg_match('~^[АаБбВвГгҐґДдЕеЄєЖжЗзИиІіЇїЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЬьЮюЯя\'\-!?—()/,.:;«»"|\n\r\\s+a-zA-Z0-9]+$~',
            trim($dataPost['text']))) {
            throw new InvalidArgumentException(
                'Текст посту може мати тільки англійські, українські літери та арабські цифри');
        }

        $this->setSection($dataPost['section']);
        $this->setImage($dataPost['image']);
        $this->setTitle($dataPost['title']);
        $this->setText($dataPost['text']);

        $this->save();

        return $this;
    }
}