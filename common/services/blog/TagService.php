<?php
namespace common\services\blog;

use backend\forms\Blogs\BlogTagForm;
use common\entities\Blog\BlogTag;
use common\entities\Blog\BlogTagDescription;
use common\helpers\StringHelper;
use common\repositories\Blog\TagRepository;

class TagService
{

    private $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(BlogTagForm $form)
    {

        $tag = BlogTag::create(
            StringHelper::getSlug($form->slug)
        );

        $descriptions = BlogTagDescription::create($form);

        $tag->assignDescription($descriptions);

        $this->repository->save($tag);

        return $tag;

    }

    public function edit(int $id, BlogTagForm $form)
    {

        $tag = $this->repository->getById($id);
        foreach ($tag->blogTagDescriptions as $description) {
            /**@var BlogTagDescription $description*/
            $description->edit($form->{$description->language_name});

            
        }

        $tag = $this->repository->getById($id);
        $tag->edit(
            StringHelper::getSlug($form->slug)
        );

        $this->repository->save($tag);

        return $tag;
    }

    public function getSlug($data)
    {
        return  StringHelper::getSlug($data);

    }

}