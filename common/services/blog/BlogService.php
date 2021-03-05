<?php
namespace common\services\blog;

use backend\forms\Blogs\BlogCreateForm;
use backend\forms\Blogs\BlogCreateMainForm;
use backend\forms\Blogs\BlogUpdateForm;
use backend\forms\Blogs\BlogUpdateMainForm;
use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogCategoryAssignment;
use common\entities\Blog\BlogCategoryChildrenDescription;
use common\entities\Blog\BlogCategoryMainDescription;
use common\entities\Blog\BlogLikes;
use common\entities\Blog\BlogTagAssignment;
use common\entities\UrlAlias;
use common\helpers\CustomerHelper;
use common\helpers\StringHelper;
use common\repositories\Blog\BlogCategoryDescriptionRepository;
use common\repositories\Blog\BlogCategoryRepository;
use common\repositories\Blog\BlogLikeRepository;
use common\repositories\Blog\TagRepository;
use common\services\TransactionManager;
use yii\helpers\ArrayHelper;

class BlogService
{
    private $repository;
    private $descriptionRepository;
    private $blogLikeRepository;
    private $transactionManager;
    private $tagRepository;

    public function __construct(
        BlogCategoryRepository $repository,
        BlogCategoryDescriptionRepository $descriptionRepository,
        TagRepository $tagRepository,
        BlogLikeRepository $blogLikeRepository,
        TransactionManager $transactionManager
    )
    {
        $this->repository = $repository;
        $this->descriptionRepository = $descriptionRepository;
        $this->tagRepository = $tagRepository;
        $this->blogLikeRepository = $blogLikeRepository;
        $this->transactionManager = $transactionManager;
    }


    //======main==========
    public function createMain(BlogCreateMainForm $form)
    {
        //get root category => root
        $parent = $this->repository->getRoot();

        //create new category
        $category = BlogCategory::create(
            StringHelper::getSlug($form->keyword)
        );

        $category->about = $form->about;

        //create descriptions []
        $descriptions = BlogCategoryMainDescription::create($form);

        //assign description category
        $category->setMainDescription($descriptions);

        // inserting new node
        /** @var BlogCategory $category*/
        $category->appendTo($parent);

        //save category
        $this->repository->save($category);

        $query = "blog_id={$category->id}";
        $keyword = $form->keyword;
        $controllers = 'blogs';
        $action = 'index';
        $id = $category->id;


        $slug = UrlAlias::create($query, $keyword,$controllers, $action, $id);

        $slug->save();

        return $category;

    }

    public function editMain(int $id, BlogUpdateMainForm $form)
    {
        //get current category
        $category = $this->repository->getById($id);
        $category->edit(StringHelper::getSlug($form->slug));

        foreach ($category->mainDescriptions as $item) {
            $description = $this->descriptionRepository->getByMainId($item->id);
            $description->edit($form->{$description->language_name});
            $category->editMainDescription($description);
        }


        $this->repository->save($category);


        return $category;
    }

    //======children=======
    public function create(BlogCreateForm $form)
    {

        $parent = $this->repository->getById($form->categories->mainCategory);

        //create blog
        $category = BlogCategory::create(StringHelper::getSlug($form->keyword));

        //create blog description lang[en ru ua]
        $descriptions = BlogCategoryChildrenDescription::create($form);

        //assignments blog descriptions
        $category->setDescription($descriptions);
        $category->setAuthor($form->author);
        $category->setImportantInformation($form->importantInformation);


        foreach ($form->photos->files as $file) {
            $category->addPhoto($file);
        }


        /** @var BlogCategory $category*/
        $category->appendTo($parent); // inserting new node



        $this->transactionManager->wrap(function () use ($category, $form) {


            if(isset($form->categories->others) && is_array($form->categories->others)){
                foreach ($form->categories->others as $otherId) {
                    $cat = $this->repository->getById($otherId);
                    $category->assignCategory($cat->id);
                }

            }

            if (isset($form->tags) && is_array($form->tags)){
                foreach ($form->tags as $tagId) {
                   $tag =  $this->tagRepository->getById($tagId);
                   $category->assignTags($tag->id);
                }
            }

            $this->repository->save($category);

        });
        //привязка вспомогательных категорий
        $query = "blog_id={$category->id}";
        $keyword = $form->keyword;
        $controllers = 'blogs';
        $action = BlogCategory::BLOG_ACTION;
        $id = $category->id;


        $slug = UrlAlias::create($query, $keyword,$controllers, $action, $id);

        $slug->save();


        return $category;

    }

    public function edit(int $id,BlogUpdateForm $form)
    {

        //поиск данной категории
        $category = $this->repository->getById($id);

        //находим родителя
        //может быть смена основной категории
        $parent = $this->repository->getById($form->categories->mainCategory);

        //если была изминен url slug
        $category->edit(StringHelper::getSlug($form->keyword));

        //важная информация
        $category->setImportantInformation($form->importantInformation);

        foreach ($category->childrenDescriptions as $item) {
            //находим данную связь
            /**@var BlogCategoryChildrenDescription $description*/
            $description = $this->descriptionRepository->getById($item->id);
            $description->edit($form->{$description->language_name});
            $category->editChildDescription($description);
        }


        //добавление изображений
        foreach ($form->photos->files as $file) {
            $category->addPhoto($file);
        }


        //удаление всех доп.категорий
        BlogCategoryAssignment::deleteAll(['blog_id' => $category->id]);
        //удаление всех тегов
        BlogTagAssignment::deleteAll(['blog_id' => $category->id]);

        $this->transactionManager->wrap(function () use ($category, $form,$parent) {


            //добавление доп.категорий
            if(isset($form->categories->others)){
                foreach ($form->categories->others as $otherId) {
                    $cat = $this->repository->getById($otherId);
                    $category->assignCategory($cat->id);
                }

            }

            //добавление тегов
            if (isset($form->tags) && is_array($form->tags)){
                foreach ($form->tags as $tagId) {
                    $tag =  $this->tagRepository->getById($tagId);
                    $category->assignTags($tag->id);
                }
            }

            //смена основной категории
            /** @var BlogCategory $category*/
            $category->appendTo($parent); // inserting new node

            $this->repository->save($category);
        });




    }

    public function movePhotoUp($id, $photoId): void
    {
        $blog = $this->repository->getById($id);
        $blog->movePhotoUp($photoId);
        $this->repository->save($blog);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $blog = $this->repository->getById($id);
        $blog->movePhotoDown($photoId);
        $this->repository->save($blog);
    }

    public function removePhoto($id, $photoId): void
    {
        $blog = $this->repository->getById($id);
        $blog->removePhoto($photoId);
        $this->repository->save($blog);
    }

    public function moveUp($id): void
    {
        $category = $this->repository->getById($id);
        $this->assertIsNotRoot($category);
        if ($prev = $category->prev) {
            $category->insertBefore($prev);
        }
        $this->repository->save($category);
    }

    public function moveDown($id): void
    {
        $category = $this->repository->getById($id);
        $this->assertIsNotRoot($category);
        if ($next = $category->next) {
            $category->insertAfter($next);
        }
        $this->repository->save($category);
    }

    public function mainRemove(int $id) : void
    {
        //get category
        $category = $this->repository->getById($id);

        //получение потомков узла
        $descendants = $category->descendants;

        $ids = $this->getIdsDescendants($descendants);

        array_push($ids, $category->id);

        //check that it is not root
        $this->assertIsNotRoot($category);

        //delete node and all descendants
        $this->repository->deleteCategoryWithChildren($category);

        foreach ($ids as $id) {
            $this->removeUrlAlias($id);
        }

    }


    private function getIdsDescendants($descendants)
    {
        $ids = [];
        foreach ($descendants as $descendant) {
            $ids[] = $descendant->id;
        }

        return $ids;

    }

    public function remove(int $id) : void
    {
        //get category
        $category = $this->repository->getById($id);
        //check that it is not root
        $this->assertIsNotRoot($category);

        //delete node and all descendants
        $this->repository->delete($category);

        $this->removeUrlAlias($category->id);
    }


    public function getSlug($data)
    {
        return  StringHelper::getSlug($data);

    }

    public function addLike(int $id)
    {

        $customerIp = CustomerHelper::getIp();

        //поиск данной записи
        $blogLike = $this->blogLikeRepository->getId($id,$customerIp);

        //блог по которому поставили like
        $blogCategory = $this->repository->getId($id);

        //если пользователь уже поставил like --
        if($blogLike){
            //удаляем данную запись
            $this->blogLikeRepository->remove($blogLike);
            $blogCategory->removeLike();

        }else{
            $like = BlogLikes::create($id,$customerIp);
            $this->blogLikeRepository->save($like);

            $blogCategory->addLike();


        }

        $this->repository->save($blogCategory);

        return $blogCategory;

    }

    private function assertIsNotRoot(BlogCategory $category)
    {
        if($category->isRoot()){
            throw new \DomainException('is root node');
        }
    }

    /*site*/
    public function getMenu()
    {
        return $this->repository->getMainMenu();
    }

    public function getMenuAbout()
    {
        return $this->repository->getAboutMenu();
    }

    private function removeUrlAlias($id, $controller = 'blogs')
    {
        UrlAlias::deleteAll(['and',
            ['controller' => $controller],
            ['id' => $id]
        ]);
    }

}
