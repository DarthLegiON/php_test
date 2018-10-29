<?php
require_once './models/Review.php';
class  NotFoundException extends Exception { }

/**
 * Class ReviewsManagerService
 */
class ReviewsManagerService
{
    /**
     * @var
     */
    public $repository;

    /**
     * @var ReviewsForm
     */
    private $validator;

    /**
     * ReviewsManagerService constructor.
     * @param $repository
     * @param $validator
     */
    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create($data)
    {
        if ($this->validator->validate($data)) {
            $review = new Review($data);
            $this->repository->save($review);
        } else {
            dump($this->validator->getErrors());
        }
    }

    /**
     * @param bool $searchQuery
     * @return array
     * @throws Exception
     */
    public function getList($searchQuery = false) :Array
    {
        $result = [];
        $reviewsCollection = $this->repository->findAll();
        if (!$searchQuery) return $reviewsCollection;
        if(!is_array($searchQuery)) {
            throw new Exception('query it should be array');
        }
        foreach($reviewsCollection as $key => $review) {
            $check = true;
            foreach ($searchQuery as $fieldName => $value) {
                if($review->{$fieldName} != $value) {
                    $check = false;
                }
            }
            if($check) {
                $result[] = $review;
            }
        }
        return $result;
    }

    /**
     * @param $id
     * @param $updateData
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function edit($id, $updateData)
    {
        if ($updateReview = $this->repository->findById($id)) {
            $data = [];
            $reflect = new ReflectionClass($updateReview);
            $props  = $reflect->getProperties();
            foreach($props as $prop) {
                if(isset($updateData[$prop->name])) {
                    $data[$prop->name] = $updateData[$prop->name];
                } else {
                    $data[$prop->name] = $updateReview->{$prop->name};
                }
            }
            if ($this->validator->validate($data)) {
                $updateReview->fill($data);
                $this->repository->update($updateReview);
            } else {
                dump($this->validator->getErrors());
            }

        } else {
            throw new NotFoundException('element with id ' . $id . 'not found');
        }
    }

    public function delete($id)
    {
        if ($deleteReview = $this->repository->findById($id)) {
            $this->repository->remove($deleteReview);
        } else {
            throw new NotFoundException('element with id ' . $id . 'not found');
        }
    }
}