<?php
require __DIR__ . '/vendor/autoload.php';
const MODE = 'DEBUG';
function dump($data) {
    if (MODE !== 'DEBUG') return;
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

require_once 'repo/index.php';
require_once 'services/ReviewsManagerService.php';
require_once 'forms/ReviewsForm.php';


$repository = new FileReviewsRepository('list.txt');
$reviewsForm = new ReviewsForm();
$reviewsManager = new ReviewsManagerService($repository, $reviewsForm);
$makeData = [
    'name' => 'Школо',
    'date' => '12.03.2018',
    'rating' => '4.7',
    'photo' => 'image.jpg',
    'text' => 'хороший продукт',
    'product_type_id' => '11',
    'collection_id' => '4',
    'product_id' => '4'
];

$updateData = [
    'name' => 'Комфорка с листьями',
    'date' => '12.03.2018',
    'rating' => '4.7',
    'photo' => 'image.jpg',
    'text' => 'Трулялялял 21321 213321321 321312312',
    'product_id' => '21'
];

$query = ['name' => 'Комфорка с листьями'];
try {
    $reviewsCollection = $reviewsManager->getList($query);
    if(count($reviewsCollection) > 0 ) {
        $id = $reviewsCollection[0]->id;
        //$reviewsManager->delete($id );
        $reviewsManager->edit($id, $updateData);
    }

    //$reviewsManager->create($makeData);
    dump($reviewsCollection);
} catch (NotFoundException $e) {
    echo $e->getMessage();
}

