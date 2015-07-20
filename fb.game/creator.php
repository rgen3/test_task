<?php

class image_creator{
    /*Объект с которым будем работать*/
    protected $image;
    /*Ширина изображения*/
    protected $width;
    /*Высота изображения*/
    protected $height;
    /*Формат изображения на выходе*/
    protected $type;
    /*Путь к папке для сохранения изображений*/
    protected $path;

    /*Ширина и высота блоков с итоговыми параметрами*/
    protected $block_right_width = 309;
    protected $block_right_height = 65;

    /*Содержит зарегистрированные цвета*/
    protected $colors;

    /*Массив процентов, чтобы не выводить одинаковые*/
    protected  $percentage = [];

    public function __construct($width, $height, $type="jpeg"){
        $this->width  = $width;
        $this->height = $height;
        $this->type   = $type;
        $this->path   = null;

        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    /**
     *
     */
    public function show($uId = null){
        $sImagePath = $this->path . "/img-$uid." . $this->type;
        if (!$this->check($sImagePath)){
            $this->create();
            if (!is_dir($this->path)){
                mkdir($this->path, "0777", true);
            }
            switch($this->type){
                case 'jpeg':
                    header('Content-Type: image/jpeg');
                    imgaejpeg($this->image);
                    //imgaejpeg($this->image, $sImagePath);
                    die();
                    break;
                case 'png':
                    imagepng($this->image, $sImagePath);
                    break;
                case 'gif':
                    imagegif($this->image, $sImagePath);
                    break;
            }
        }
        return $sImagePath;
    }

    /**
     *
     */
    public function check($sImagePath){
        return (bool)file_exists($sImagePath);
    }

    /**
     *
     */
    public function create(){

        imageFilledRectangle($this->image, 0, 0,$this->width, $this->height, $this->colors["bg"]);

        /*Ставим превью нужного дома*/
        $this->house_preview = imagecreatefromjpeg($this->main_preview);
        imagecopymerge($this->image, $this->house_preview, 485, 3, 0, 0, 310, 175, 100);

        /*Выводим логотип*/

        $this->user_image = imagecreatefromjpeg("images/logo.jpg");
        imagecopymerge($this->image, $this->user_image, 757, 3, 0, 0, 38, 20, 100);

        /*Ставим пользовательскую аватарку*/
        $this->user_image = imagecreatefromjpeg($this->user_ava);
        $this->user_image = $this->resize($this->user_image, 175);
        imagecopymerge($this->image, $this->user_image, 3, 3, 0, 0, 175, 175, 100);

        /*Выводим 3d планировку дома*/
        $this->show_3d($this->preview_3d_1, 180, 95, -20, 320, 0, 0);
        $this->show_3d($this->preview_3d_2, 180, 95, 130, 320, 0, 0);
        $this->show_3d($this->preview_3d_3, 180, 95, 280, 320, 0, 0);

        /*Выводим блок для текстовой записи*/
        $this->info_blocks(3, 190, 470, 120, $this->colors["gray"]);

        /*Выводим 3 блока с подписями справа*/
        //Верхний
        $this->info_blocks(485, 190, $this->block_right_width, $this->block_right_height, $this->colors["light_green"]);
        //Центральный
        $this->info_blocks(485, 265, $this->block_right_width, $this->block_right_height, $this->colors["dark_green"]);
        //Нижний
        $this->info_blocks(485, 340, $this->block_right_width, $this->block_right_height, $this->colors["wine"]);

        // рисуем рамку
        imageRectangle($this->image, 0, 0, $this->width-1, $this->height-1, $this->colors["border"]);

        /*Выводим текст*/
        imagettftext($this->image, 18, 0, 210, 75, $this->colors["dark_gray"], "fonts/marckscript/MarckScript-Regular.ttf", "Какой дом лучше всего");
        imagettftext($this->image, 18, 0, 195, 110, $this->colors["dark_gray"], "fonts/marckscript/MarckScript-Regular.ttf", "подходит вашей личности?");

        /*467px*/
        $iFontSize = 20;
        $iMaxWidth = 467;

        do{
            list($continue, $iCurrentWidth) = $this->get_font_width("fonts/roboto/Roboto-Bold.ttf", $iFontSize, $this->main_text_1, $iMaxWidth);
            if (!$continue) break;
            $iFontSize-=1;
        }
        while(true);
        $iMarginLeft = ($iMaxWidth - $iCurrentWidth) / 2;
        imagettftext($this->image, $iFontSize, 0, $iMarginLeft, 225, $this->colors["dark_gray"], "fonts/roboto/Roboto-Bold.ttf", $this->main_text_1);

        $iFontSize = 25;

        list($continue, $iCurrentWidth) = $this->get_font_width("fonts/roboto/Roboto-Bold.ttf", $iFontSize, $this->main_text_2, $iMaxWidth);
        $marginLeft = $iMarginLeft = ($iMaxWidth - $iCurrentWidth) / 2;
        imagettftext($this->image, $iFontSize, 0, $marginLeft, 285, $this->colors["dark_gray"], "fonts/roboto/Roboto-Bold.ttf", $this->main_text_2);

        /*Выводим иконки*/
        imagettftext($this->image, 18, 0, 505, 232, $this->colors["white"], "fonts/fa/fontawesome-webfont.ttf", "&#xf21d;");
        imagettftext($this->image, 18, 0, 500, 308, $this->colors["white"], "fonts/fa/fontawesome-webfont.ttf", "&#xf20e;");
        imagettftext($this->image, 18, 0, 500, 383, $this->colors["white"], "fonts/fa/fontawesome-webfont.ttf", "&#xf06c;");

        /*Выводим текст по параметрам*/
        imagettftext($this->image, 18, 0, 535, 232, $this->colors["white"], "fonts/roboto/Roboto-Bold.ttf", "Пространство:");
        imagettftext($this->image, 18, 0, 535, 308, $this->colors["white"], "fonts/roboto/Roboto-Bold.ttf", "Планировка:");
        imagettftext($this->image, 18, 0, 535, 382, $this->colors["white"], "fonts/roboto/Roboto-Bold.ttf", "Экологичность:");

        /*Выводим процентовку*/
        imagettftext($this->image, 18, 0, 720, 230, $this->colors["white"], "fonts/roboto/Roboto-Bold.ttf", $this->get_percentage());
        imagettftext($this->image, 18, 0, 720, 308, $this->colors["white"], "fonts/roboto/Roboto-Bold.ttf", $this->get_percentage());
        imagettftext($this->image, 18, 0, 720, 382, $this->colors["white"], "fonts/roboto/Roboto-Bold.ttf", $this->get_percentage());
    }

    /**
     * @param $sColorName
     * @param $sR
     * @param $sG
     * @param $sB
     */
    public function allocate_color($sColorName, $sR, $sG, $sB){
        $this->colors[$sColorName] = imageColorAllocate($this->image, $sR, $sG, $sB);
    }

    /**
     * @param $sColorName
     * @param $sColor
     * @throws Exception
     */
    public function allocate_color_hex($sColorName, $sColor){
        list($sR, $sG, $sB) = $this->hex2rgb($sColor);
        $this->allocate_color($sColorName, $sR, $sG, $sB);
    }

    /**
     *
     */
    public function create_filled_rectangle(){

    }

    /**
     * @param $path
     */
    public function setPath($sPath){
        $this->path = $sPath;
    }

    public function set_main_preview($sUrl){
        $this->main_preview = $sUrl;
    }

    public function set_user_ava($sUrl){
        $this->user_ava = $sUrl;
    }

    /**
     * @param $str1
     * @param $str2
     */
    public function set_main_text($str1, $str2){
        $this->main_text_1 = $str1;
        $this->main_text_2 = $str2;
    }

    public function set_3d_preveiew_1($sUrl){
        $this->preview_3d_1 = $sUrl;
    }

    public function set_3d_preveiew_2($sUrl){
        $this->preview_3d_2 = $sUrl;
    }

    public function set_3d_preveiew_3($sUrl){
        $this->preview_3d_3 = $sUrl;
    }

    /**
     * @param $sFontPath
     * @param $iFontSize
     * @param $sText
     * @param $iMaxWidth
     * @return array
     */
    protected function get_font_width($sFontPath, $iFontSize, $sText, $iMaxWidth){
        $aSize = imagettfbbox($iFontSize, 0, $sFontPath, $sText);
        $iCurrentWidth = abs($aSize[2] - $aSize[0]);
        return [(bool)($iCurrentWidth >= $iMaxWidth), $iCurrentWidth];
    }

    /**
     * @return string
     */
    protected function get_percentage(){
        do{
            $iNum = round(rand(80, 100) * 2, -1) / 2;
        }while (in_array($iNum, $this->percentage));
        $this->percentage[] = $iNum;

        return (string)"$iNum%";
    }

    /**
     * @param $iX1
     * @param $iY1
     * @param $iWidth
     * @param $iHeight
     * @param $sColorName
     */
    protected function info_blocks($iX1, $iY1, $iWidth, $iHeight, $sColorName){
        $iX2 = $iX1 + $iWidth;
        $iY2 = $iY1 + $iHeight;
        imageFilledRectangle($this->image, $iX1, $iY1, $iX2, $iY2, $sColorName);
    }

    /**
     * @param $rSource
     * @param $iWidth
     * @return resource
     */
    protected function resize($rSource, $iWidth){
        $iOrigWidth = imagesx($rSource);
        $iOrigHeight = imagesy($rSource);

        $iHeight = (($iOrigHeight * $iWidth) / $iOrigWidth);

        $rNewImage = imagecreatetruecolor($iWidth, $iHeight);

        imagecopyresized($rNewImage, $rSource,
            0, 0, 0, 0,
            $iWidth, $iHeight,
            $iOrigWidth, $iOrigWidth);
        return $rNewImage;
    }

    /**
     * @param $sUrl
     * @param $iWidth
     * @param $iHeight
     * @param $iX1
     * @param $iY1
     * @param $iX2
     * @param $iY2
     */
    protected function show_3d($sUrl, $iWidth, $iHeight, $iX1, $iY1, $iX2, $iY2){
        $rImg = imagecreatefromjpeg($sUrl);
        $planWidth = 180;
        $planHeight = 95;
        $rImg = $this->resize($rImg, $iWidth);

        imagecopymerge($this->image, $rImg, $iX1, $iY1, $iX2, $iY2, $iWidth, $iHeight, 100);
    }

    /**
     * @param $sColor
     * @return array
     * @throws Exception
     */
    private function hex2rgb($sColor){
        if (!preg_match("/^(?:#?)(?:([0-9A-F]){3}|(?1){6})$/i", $sColor)){
            throw new Exception("Color ($sColor) is incorrect");
        }
        $sColor = trim($sColor, "#");
        $iSplitBy = mb_strlen($sColor) == 3 ? 1 : 2;
        $aResult = str_split($sColor, $iSplitBy);

        foreach ($aResult as &$v){
            if ($iSplitBy === 1){
                $v.=$v;
            }
            $v = hexdec($v);
        }
        return $aResult;
    }

}

$oImg = new image_creator(800, 420, 'png');
$oImg->allocate_color_hex("bg", "fff");
$oImg->allocate_color_hex("border", "b4d16b");
$oImg->allocate_color_hex("light_green", "b4d16b");
$oImg->allocate_color_hex("dark_green", "6EA827");
$oImg->allocate_color_hex("wine", "782629");
$oImg->allocate_color_hex("gray", "efefef");
$oImg->allocate_color_hex("white", "fff");
$oImg->allocate_color_hex("dark_gray", "252525");


$username = $_POST["name"];
$uId = $_POST["id"];
$oImg->set_main_text("$username, дом вашей мечты - ", "Новогодняя романтика");
$oImg->set_user_ava("https://graph.facebook.com/$uId/picture?type=large");
$oImg->set_main_preview("http://gshome.ru/sites/default/files/styles/house_sim/public/zs_f1g.jpg");
$oImg->set_3d_preveiew_1("http://gshome.ru/sites/default/files/styles/house_small/public/k_3d3.jpg?itok=u77aViK_");
$oImg->set_3d_preveiew_2("http://gshome.ru/sites/default/files/styles/house_small/public/k_3d2.jpg?itok=bavHqZP4");
$oImg->set_3d_preveiew_3("http://gshome.ru/sites/default/files/styles/house_small/public/k_3d1.jpg?itok=bavHqZP4");
$oImg->setPath("img/$uId");

echo $oImg->show($uId);
