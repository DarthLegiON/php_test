<?php
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class ReviewsForm {
    private $errors;
    private $data;

    /**
     * @param $data
     * @return bool
     */
    public function validate($data) {
        $this->data = $data;
        $this->errors = [];
        $this->beforeValidate();
        $this->setConstraint();

        $validator = Validation::createValidator();
        $errors = $validator->validate($this->data, $this->constraint);

        if($errors->count() === 0) return true;
        $groupedErrors = array();
        foreach ($errors as $error) {
            $key = str_replace(array('[', ']'), '', $error->getPropertyPath());
            $groupedErrors[$key][] = $error->getMessage();
        }
        $this->errors = $groupedErrors;

        return false;
    }

    public function setConstraint() {
        $numberСonstraint =  new Assert\Regex(array(
            'pattern' => '/^[0-9]\d*$/',
            'message' => 'Please use only positive numbers.'
        ));
        $this->constraint  = new Assert\Collection(array(
            'name' => new Assert\Length(array('min' => 5)),
            'rating' => new Assert\Length(array('min' => 3)),
            'photo' => new Assert\Length(array('min' => 3)),
            'text' => new Assert\Length(array('min' => 12)),
            'date' => new Assert\Date(),
            'collection_id' => $numberСonstraint,
            'product_type_id' => $numberСonstraint,
            'product_id' => $numberСonstraint

        ));

    }

     public function getErrors() {
        return $this->errors;
     }

     public function beforeValidate() {
        if ($this->data && $this->data['date']) {
            $this->data['date'] = new DateTime($this->data['date']);
        }
     }
}
