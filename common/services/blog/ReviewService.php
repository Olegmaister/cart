<?php
namespace common\services\blog;

use common\entities\Blog\review\BlogReview;
use common\entities\Customer;
use common\repositories\Blog\BlogCategoryRepository;
use common\repositories\Blog\ReviewRepository;
use frontend\forms\blog\ReviewForm;

class ReviewService
{
    private $repository;
    private $categoryRepository;

    public function __construct(
        ReviewRepository $repository,
        BlogCategoryRepository $categoryRepository
        )
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    public function add(ReviewForm $form, int $blogId, Customer $customer = null)
    {
        if(isset($form->reviewId) && !empty($form->reviewId)){
            $parent = $this->repository->getById($form->reviewId);
        }else{
            //get root category => root
            $parent = $this->repository->getRoot();
        }


        //get blog
        $blog = $this->categoryRepository->getById($blogId);
        //create new comment
        $review = BlogReview::create($blogId, $customer);

        //assign description comment
        $review->assignDescription($form);

        /**@var BlogReview*/
        $review->appendTo($parent);

        $this->repository->save($review);
    }

    public function remove(int $id)
    {
        $review = $this->repository->getById($id);
        //check that it is not root
        $this->assertIsNotRoot($review);

        $this->repository->deleteCategoryWithChildren($review);
    }

    public function changeStatus(int $id , int $status)
    {
        $review = $this->repository->getById($id);
        $review->changeStatus($status);
        $this->repository->save($review);
    }

    private function assertIsNotRoot(BlogReview $review)
    {
        if($review->isRoot()){
            throw new \DomainException('is root node');
        }
    }
}