<?php

class ImageController extends ControllerBase
{
    public function cacheDir()
    {
        return getcwd() . "/imageCache/";
    }

    public function dir()
    {
        return getcwd() . "/";
    }

    public function beforeExecuteRoute($dispatcher)
    {
        $this->view->setRenderLevel(1);

        if (!is_dir($this->cacheDir())) {
            mkdir($this->cacheDir(), 0777, 1);
        };
    }

    public function zoom1Action($WxH)
    {

        $uri = $this->request->getURI();
        $uri = explode("/", $uri);
        $uri = array_slice($uri, 4);
        $uri = implode('/', $uri);
        //$path= $this->cacheDir().$uri;
        $path = $this->dir() . $uri;

        $WxH = explode('x', $WxH);
        $w = $WxH[0];
        $h = $WxH[1];
        $quality = 95;

        $file = str_replace("/", "_", $w . "x" . $h . "_" . $quality . "_" . __FUNCTION__ . "_" . $uri);
        if (file_exists($file)) {
            header('Content-Type: image/jpeg');
            print file_get_contents($file);
        } else {
            if (!file_exists($path)) {
                throw new Exception('File not found', 404);
            }

            ob_start();
            $hImageInfo = getimagesize($path);
            $format = $hImageInfo[2];
            switch ($format) {
                case 1: //GIF
                    $imagecreate = "imagecreatefromgif";
                    break;
                case 2: //JPG
                    $imagecreate = "imagecreatefromjpeg";
                    break;
                case 3: //PNG
                    $imagecreate = "imagecreatefrompng";
                    break;
                case 4: //SWF
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 5: //PSD
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 6: //BMP
                    $imagecreate = "imagecreatefromwbmp";
                    break;
                case 7: //TIFF(intel)
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 8: //TIFF(motorola)
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 9: //JPC
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 10: //JP2
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 11: //JPX
                    $imagecreate = "imagecreatefromgd";
                    break;

            };

            $img = $imagecreate($path);

            $w = floatval($w);
            $h = floatval($h);

            if ($w == 0 && $h != 0) $w = imagesx($img);
            if ($w != 0 && $h == 0) $h = imagesy($img);

            if (
                $w > imagesx($img) &&
                $h > imagesy($img)
            ) {
                return false;
            };

            if ($w == 0)
                $wE = 1;
            else
                $wE = imagesx($img) / $w;

            if ($h == 0)
                $hE = 1;
            else
                $hE = imagesy($img) / $h;

            $e = ($wE > $hE) ? $wE : $hE;

            $w1 = imagesx($img) / $e;
            $h1 = imagesy($img) / $e;

            $canvas = imagecreatetruecolor($w1, $h1);
            imagecopyresized($canvas, $img, 0, 0, 0, 0, $w1, $h1, imagesx($img), imagesy($img));

            header('Content-Type: image/jpeg');
            imagejpeg($canvas, null, $quality);

            imagedestroy($canvas);
            imagedestroy($img);

            $content = ob_get_contents();
            file_put_contents($this->cacheDir() . $file, $content);
        }
    }

    public function zoom2Action($WxH)
    {


        $uri = $this->request->getURI();
        $uri = explode("/", $uri);
        $uri = array_slice($uri, 4);
        $uri = implode('/', $uri);
        //$path= $this->cacheDir().$uri;
        $path = $this->dir() . $uri;

        $WxH = explode('x', $WxH);
        $w = $WxH[0];
        $h = $WxH[1];
        $quality = 95;

        $file = str_replace("/", "_", $w . "x" . $h . "_" . $quality . "_" . __FUNCTION__ . "_" . $uri);
        if (file_exists($file)) {
            header('Content-Type: image/jpeg');
            print file_get_contents($file);
        } else {
            if (!file_exists($path)) {
                throw new Exception('File not found', 404);
            }

            ob_start();
            $hImageInfo = getimagesize($path);
            $format = $hImageInfo[2];
            switch ($format) {
                case 1: //GIF
                    $imagecreate = "imagecreatefromgif";
                    break;
                case 2: //JPG
                    $imagecreate = "imagecreatefromjpeg";
                    break;
                case 3: //PNG
                    $imagecreate = "imagecreatefrompng";
                    break;
                case 4: //SWF
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 5: //PSD
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 6: //BMP
                    $imagecreate = "imagecreatefromwbmp";
                    break;
                case 7: //TIFF(intel)
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 8: //TIFF(motorola)
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 9: //JPC
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 10: //JP2
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 11: //JPX
                    $imagecreate = "imagecreatefromgd";
                    break;

            };

            $img = $imagecreate($path);

            if ($w == 0 && $h != 0) $w = imagesx($img);
            if ($w != 0 && $h == 0) $h = imagesy($img);

            $ww = imagesx($img);
            $hh = imagesy($img);

            $wE = $ww / $w;
            $hE = $hh / $h;
            $e = ($wE < $hE) ? $wE : $hE;

            $nw = $ww / $e;
            $nh = $hh / $e;

            $dx = $nw - $w;
            $dy = $nh - $h;

            if ($wE > $hE) {
                $img1 = imagecreatetruecolor($nw, $nh);
                imagecopyresized($img1, $img, 0, 0, 0, 0, $nw, $nh, imagesx($img), imagesy($img));
                $img2 = imagecreatetruecolor($w, $h);
                imagecopyresized($img2, $img1, 0, 0, $dx / 2, 0, $w, $h, $w, $h);
            } else {
                $img1 = imagecreatetruecolor($nw, $nh);
                imagecopyresized($img1, $img, 0, 0, 0, 0, $nw, $nh, imagesx($img), imagesy($img));
                $img2 = imagecreatetruecolor($w, $h);
                imagecopyresized($img2, $img1, 0, 0, 0, $dy / 2, $w, $h, $w, $h);

            };

            header('Content-Type: image/jpeg');
            imagejpeg($img2, null, $quality);

            imagedestroy($img2);
            imagedestroy($img1);
            imagedestroy($img);

            $content = ob_get_contents();
            file_put_contents($this->cacheDir() . $file, $content);
        }
    }

    public function zoom3Action($WxH)
    {

        $uri = $this->request->getURI();
        $uri = explode("/", $uri);
        $uri = array_slice($uri, 4);
        $uri = implode('/', $uri);
        //$path= $this->cacheDir().$uri;
        $path = $this->dir() . $uri;

        $WxH = explode('x', $WxH);
        $w = $WxH[0];
        $h = $WxH[1];
        $quality = 95;

        $file = str_replace("/", "_", $w . "x" . $h . "_" . $quality . "_" . __FUNCTION__ . "_" . $uri);

        if (file_exists($file)) {
            header('Content-Type: image/jpeg');
            print file_get_contents($file);
        } else {
            if (!file_exists($path)) {
                throw new Exception('File not found', 404);
            }

            ob_start();
            $hImageInfo = getimagesize($path);
            $format = $hImageInfo[2];
            switch ($format) {
                case 1: //GIF
                    $imagecreate = "imagecreatefromgif";
                    break;
                case 2: //JPG
                    $imagecreate = "imagecreatefromjpeg";
                    break;
                case 3: //PNG
                    $imagecreate = "imagecreatefrompng";
                    break;
                case 4: //SWF
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 5: //PSD
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 6: //BMP
                    $imagecreate = "imagecreatefromwbmp";
                    break;
                case 7: //TIFF(intel)
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 8: //TIFF(motorola)
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 9: //JPC
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 10: //JP2
                    $imagecreate = "imagecreatefromgd";
                    break;
                case 11: //JPX
                    $imagecreate = "imagecreatefromgd";
                    break;

            };

            $img = $imagecreate($path);

            if ($w == 0 && $h != 0) $w = imagesx($img);
            if ($w != 0 && $h == 0) $h = imagesy($img);

            $dw = imagesx($img) - $w;
            $dh = imagesy($img) - $h;

            $img1 = imagecreatetruecolor($w, $h);
            imagecopyresized($img1, $img, 0, 0, $dw / 2, $dh / 2, $w, $h, imagesx($img) - $dw, imagesy($img) - $dh);

            header('Content-Type: image/jpeg');
            imagejpeg($img1, null, $quality);

            imagedestroy($img1);
            imagedestroy($img);

            $content = ob_get_contents();
            file_put_contents($this->cacheDir() . $file, $content);
        }
    }

    public function indexAction()
    {

    }

    public function testAction()
    {
        echo md5_file($this->cacheDir() . "7_100x200_95_zoom3Action_upload_BtgXcKyIMAABUPk.jpg");
        echo __FUNCTION__;
        echo "test";
        echo "<br>";
        $ext = function_exists('imagecopyresized') ? 'GD' : "";
        echo $ext;
        echo "<br>";
        $ext = function_exists('NewMagickWand') ? 'MagickWand' : "";
        echo $ext;
        echo "<br>";

    }

}