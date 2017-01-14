<?php
/**
  * Credits goes to an anonymous at http://usphp.com/manual/ro/function.imageantialias.php
  */
function imagesmoothcircle( &$img, $cx, $cy, $cr, $color ) {
        $ir = $cr;
        $ix = 0;
        $iy = $ir;
        $ig = 2 * $ir - 3;
        $idgr = -6;
        $idgd = 4 * $ir - 10;
        $fill = imageColorExactAlpha( $img, $color[ 'R' ], $color[ 'G' ], $color[ 'B' ], 0 );
        imageLine( $img, $cx + $cr - 1, $cy, $cx, $cy, $fill );
        imageLine( $img, $cx - $cr + 1, $cy, $cx - 1, $cy, $fill );
        imageLine( $img, $cx, $cy + $cr - 1, $cx, $cy + 1, $fill );
        imageLine( $img, $cx, $cy - $cr + 1, $cx, $cy - 1, $fill );
        $draw = imageColorExactAlpha( $img, $color[ 'R' ], $color[ 'G' ], $color[ 'B' ], 42 );
        imageSetPixel( $img, $cx + $cr, $cy, $draw );
        imageSetPixel( $img, $cx - $cr, $cy, $draw );
        imageSetPixel( $img, $cx, $cy + $cr, $draw );
        imageSetPixel( $img, $cx, $cy - $cr, $draw );
        while ( $ix <= $iy - 2 ) {
            if ( $ig < 0 ) {
                $ig += $idgd;
                $idgd -= 8;
                $iy--;
            } else {
                $ig += $idgr;
                $idgd -= 4;
            }
            $idgr -= 4;
            $ix++;
            imageLine( $img, $cx + $ix, $cy + $iy - 1, $cx + $ix, $cy + $ix, $fill );
            imageLine( $img, $cx + $ix, $cy - $iy + 1, $cx + $ix, $cy - $ix, $fill );
            imageLine( $img, $cx - $ix, $cy + $iy - 1, $cx - $ix, $cy + $ix, $fill );
            imageLine( $img, $cx - $ix, $cy - $iy + 1, $cx - $ix, $cy - $ix, $fill );
            imageLine( $img, $cx + $iy - 1, $cy + $ix, $cx + $ix, $cy + $ix, $fill );
            imageLine( $img, $cx + $iy - 1, $cy - $ix, $cx + $ix, $cy - $ix, $fill );
            imageLine( $img, $cx - $iy + 1, $cy + $ix, $cx - $ix, $cy + $ix, $fill );
            imageLine( $img, $cx - $iy + 1, $cy - $ix, $cx - $ix, $cy - $ix, $fill );
            $filled = 0;
            for ( $xx = $ix - 0.45; $xx < $ix + 0.5; $xx += 0.2 ) {
                for ( $yy = $iy - 0.45; $yy < $iy + 0.5; $yy += 0.2 ) {
                    if ( sqrt( pow( $xx, 2 ) + pow( $yy, 2 ) ) < $cr ) $filled += 4;
                }
            }
            $draw = imageColorExactAlpha( $img, $color[ 'R' ], $color[ 'G' ], $color[ 'B' ], ( 100 - $filled ) );
            imageSetPixel( $img, $cx + $ix, $cy + $iy, $draw );
            imageSetPixel( $img, $cx + $ix, $cy - $iy, $draw );
            imageSetPixel( $img, $cx - $ix, $cy + $iy, $draw );
            imageSetPixel( $img, $cx - $ix, $cy - $iy, $draw );
            imageSetPixel( $img, $cx + $iy, $cy + $ix, $draw );
            imageSetPixel( $img, $cx + $iy, $cy - $ix, $draw );
            imageSetPixel( $img, $cx - $iy, $cy + $ix, $draw );
            imageSetPixel( $img, $cx - $iy, $cy - $ix, $draw );
        }
    }

/**
 * Draw a cross
 *
 * @param ressource $img
 * @param int $x1
 * @param int $y1
 * @param int $x2
 * @param int $y2
 * @param ressource $color
 */
function imagecross(&$img, $x1, $y1, $x2, $y2, $color)
{
	imageline($img, $x1, $y1, $x2, $y2, $color);
	imageline($img, $x2, $y1, $x1, $y2, $color);
}



/**
 * credits to Alexander Gavazov at http://fr.php.net/manual/en/function.imagettfbbox.php
 */
function imagettfbboxextended($font_size, $font_angle, $font_file, $text) {
    $box = imagettfbbox($font_size, $font_angle, $font_file, $text);

    $min_x = min(array($box[0], $box[2], $box[4], $box[6]));
    $max_x = max(array($box[0], $box[2], $box[4], $box[6]));
    $min_y = min(array($box[1], $box[3], $box[5], $box[7]));
    $max_y = max(array($box[1], $box[3], $box[5], $box[7]));

    return array(
        'left' => ($min_x >= -1) ? -abs($min_x + 1) : abs($min_x + 2),
        'top' => abs($min_y),
        'width' => $max_x - $min_x,
        'height' => $max_y - $min_y,
        'box' => $box
    );
}


?>