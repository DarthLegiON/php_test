<?php
require_once 'Model.php';
class Review extends Model
{
    public $name;
    public $date;
    public $rating;
    public $photo;
    public $text;
    public $product_id;
    public $product_type_id;
    public $collection_id;

    /**
     * Review constructor.
     * @param $data
     */
    public function __construct($data) {
        $this->id = $this->generateId();
        $this->fill($data);
    }

    public function fill($data) {
        foreach ($data as $fieldName => $value) {
            if (property_exists(self::class, $fieldName)) {
                $this->{$fieldName} = $value;
            }
        }
    }
}