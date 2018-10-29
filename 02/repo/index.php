<?php
interface repository {
    public function saveAll($items);
    public function findAll();
    public function findById($id);
    public function save($item);
    public function remove($id);
}

class FileReviewsRepository implements repository {
    /**
     * @var string
     */
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function findAll() {
        $rows = file($this->file);
        $items = [];
        foreach ($rows as $row) {
            $items[] = unserialize($row);
        }
        return $items;
    }

    /**
     * @param $reviews
     * @throws Exception
     */
    public function saveAll($reviews) {
        $this->clear();
        foreach ($reviews as $review) {
            $this->save($review);
        }
    }

    /**
     * @param $review
     * @throws Exception
     */
    public function save($review) {
        if (!file_put_contents($this->file, serialize($review) . PHP_EOL, FILE_APPEND)) {
            throw new \Exception('errors save storage');
        };
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function findById($id) {
        $collection = $this->findAll();
        foreach ($collection as $review) {
            if($review->id === $id) return $review;
        }
        return null;
    }

    //shit with txt
    public function remove($deleteReview) {
        $collection = $this->findAll();
        foreach ($collection as $index => $review) {
            if ($review->id === $deleteReview->id) {
                unset($collection[$index]);
            }
        }
        $this->saveAll($collection);
    }

    //shit with txt
    public function update($updateReview) {
        $collection = $this->findAll();
        foreach ($collection as $index => $review) {
            if ($review->id === $updateReview->id) {
                $collection[$index] = $updateReview;
            }
        }
        $this->saveAll($collection);
    }

    private function clear() {
        $fp = fopen($this->file, "r+");
        ftruncate($fp, 0);
        fclose($fp);
    }
}