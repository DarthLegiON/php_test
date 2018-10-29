<?php
const MODE = 'DEBUG';
const DEFAULT_DIRECTORY = 'images';
$imageManger = new ImageManager();
function dump($data) {
    if (MODE !== 'DEBUG') return;
    echo '</pre>';
    print_r($data);
    echo '</pre>';
}
?>
<html>
    <header>
        <title>search images script</title>
    </header>
    <body>
        <form action="/01/" method="get">
            <label for="image_name">Название картинки (доступные форматы: jpg, png, jpeg):</label>
            <b>Пример: spider.jpg</b>
            <br>
            <input type="text" name="image_name">
            <div>
                <button>Найти</button>
            </div>
        </form>
    </body>
</html>

<?php

try {
    if (isset($_GET['image_name'])) {
        $imageName = $_GET['image_name'];
        $imageManger->search(($imageName));
    }
}catch (Exception $e) {
    $imageManger->showError($e);
}

class ImageManager {
    /**
     * @var string
     *
     */
    private $imageDirectory;

    public function __construct($imageDirectory = false) {
        if(!$imageDirectory) $imageDirectory = DEFAULT_DIRECTORY;
        $this->imageDirectory = $imageDirectory;
        $this->avaliableExtentions = ['jpg', 'jpeg', 'png'];
    }

    /**
     * @param $imageName
     * @throws Exception
     */
    public function search($imageName) {
        $this->validateImageName($imageName);
        $searchImg = false;
        foreach (new DirectoryIterator('./' . $this->imageDirectory) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            if ($fileInfo->getFilename() === $imageName) {
                $searchImg =  $fileInfo->getPath() . '/' . $fileInfo->getFilename();
            }
        }
        if(!$searchImg) {
            throw  new \Exception('Изображение не найденно');
        }
        $this->showImage($searchImg);
    }

    /**
     * @param $image
     * print image
     */
    public function showImage($image) {
        ob_start();
        ?>
        <div>
            Найденная картинка:
            <image src="<?= $image ?>"></image>
        </div>
        <?
        $content = ob_get_contents();
        ob_clean();
        echo $content;
    }

    /**
     * @param $err
     */
    public function showError($err) {
        ob_start();
        ?>
        <div>
            Произошла ощибка: <b><?= $err->getMessage() ?></b>

        </div>
        <?
        $content = ob_get_contents();
        ob_clean();
        echo $content;
    }

    /**
     * @param $imageName
     * @throws Exception
     */
    private function validateImageName($imageName) {
        if(strlen($imageName) <= 0) throw new \Exception('Название не должно быть пустым!');
        $imageData = array_map('trim', explode('.', $imageName));
        if(!isset($imageData[1])) throw new \Exception('Не указанно расширение');
        if (!in_array($imageData[1], $this->avaliableExtentions)) throw new \Exception('Доступны только раширения: jpg, png, jpeg');
    }
}
