<?php

namespace Bishopm\Connexion\Libraries;

require_once('gdext.inc.php');

class Chord
{

	private $data;
	private $barre;
	private $width;
	private $height;
	private $margin;
	private $bgColor;
	private $bgPicture;
	private $gridColor;
	private $symbolColor;
	private $maxFrets;
	private $circleSize;
	private $startingFret;
	private $nutSize;
	private $showUnstrummedStrings;
	private $showZeros;
	private $upperSymbolSize;
	private $fontStartingFret;
	private $fontStartingFretSize;
	private $title;
	private $fontTitle;
	private $fontTitleSize;

	/**
	 * Build a new chord object
	 *
	 * @param array $data
	 */
	function __construct($data = array())
	{
		if(is_array($data))
		{
			$this->data = $data;

			$this->width = 90;
			$this->height = 120;
			$this->margin = array('top'=>5,'right'=>7,'bottom'=>5,'left'=>7);
			$this->bgColor = array(255,255,255);
			$this->gridColor = array(0,0,0);
			$this->symbolColor = array(0,0,0);
			$this->maxFrets = 5;
			$this->fontStartingFret = 1;
			$this->fontStartingFretSize = 10.0;
			$this->fontTitle = 5;
			$this->fontTitleSize = 16.0;
			$this->bgPicture = '';
			$this->circleSize = 0.5; //proportional to fret spacing size
			$this->barreSize = 0.30; //proportional to fret spacing size
			$this->nutSize = 0.15; //proportional to fret spacing size
			$this->startingFret = 0;
			$this->showUnstrummedStrings = true;
			$this->showZeros = true;
			$this->upperSymbolSize = 0.5; //proportional to string spacing size

		}
		else
		{
			throw new Exception('You must provide an array');
		}
	}


	/**
	 * Draw the chord according to given parameters
	 *
	 */
	function draw($fname)
	{
		//header('Content-type: image/png');
		$img = imagecreatetruecolor($this->width, $this->height);

		if(!$img)
			throw new Exception('Cannot Initialize new GD image stream');

		// Values computed and used for the drawing
		//count number of strings and compute space between strings
		$nbStrings = count($this->data);
		$realWidth = $this->width - $this->margin['left'] - $this->margin['right'];
		$stringSpacing = ($realWidth / ($nbStrings-1));
		$upperSymbolSize =  intval(round($stringSpacing * $this->upperSymbolSize));	//space needed to draw the "o" or "x"
		$totalTopMargin = $this->margin['top'] + $upperSymbolSize;
		$titleMargin = 0;
		//if theres a title, compute additionnal top margin induced
		if(!empty($this->title))
		{
			if(is_int($this->fontTitle))
			{
				$titleMargin = imagefontheight($this->fontTitle);
			}
			else
			{
				$box = imagettfbboxextended($this->fontTitleSize, 0, $this->fontTitle, $this->title);
				$titleMargin = $box['height'];
			}
		}
		$totalTopMargin += $titleMargin;
		$realHeight = $this->height - $totalTopMargin - $this->margin['bottom'];
		$fretsSpacing = $realHeight / ($this->maxFrets);


		//create colors
		$bgColor = imagecolorallocate($img, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
		$gridColor = imagecolorallocate($img, $this->gridColor[0], $this->gridColor[1], $this->gridColor[2]);
		$symbolColor = imagecolorallocate($img, $this->symbolColor[0], $this->symbolColor[1], $this->symbolColor[2]);

		//clear image with background color
		imagefilledrectangle($img, 0, 0, $this->width, $this->height, $bgColor);


		//if there is a background picture, set it
		if(!empty($this->bgPicture))
		{
			$bg = file_get_contents($this->bgPicture);
			if($bg)
			{
				$bgPic = imagecreatefromstring($bg);
				if($bgPic)
				{
					imagecopy($img, $bgPic, 0, 0, 0, 0, $this->width, $this->height);
					imagedestroy($bgPic);
				}
			}
		}


		//if there's a title, draw it
		if(!empty($this->title))
		{
			if(is_int($this->fontTitle))
			{
				$font_width = imagefontwidth($this->fontTitle);
				imagestring($img, $this->fontTitle, ($this->width - $font_width) / 2.0, $this->margin['top'], $this->title, $symbolColor);
			}
			else
			{
				$box = imagettfbboxextended($this->fontTitleSize, 0, $this->fontTitle, $this->title);
				$font_width = $box['width'];
				imagettftext($img, $this->fontTitleSize, 0, ($this->width - $font_width) / 2.0, $this->margin['top'] + $box['top'] - 4, $symbolColor, $this->fontTitle, $this->title);
			}
		}



		//draw the strings
		$xoffset = 0;
		for($i=0;$i<$nbStrings;$i++)
		{
			imageline($img, $this->margin['left']+$xoffset, $totalTopMargin, $this->margin['left']+$xoffset,  $this->height - $this->margin['bottom'],  $gridColor);
			$xoffset += $stringSpacing;
		}

		//draw the frets
		$yoffset = 0;
		for($i=0;$i<=$this->maxFrets;$i++)
		{
			if($i==0 && $this->startingFret == 0)
			{
				//if the starting fret is 0 then we draw the nut
				imagefilledrectangle($img, $this->margin['left'], $totalTopMargin + $yoffset, $this->width - $this->margin['right'], $totalTopMargin + ($fretsSpacing*$this->nutSize) ,  $gridColor);
			}
			else
			{
				imageline($img, $this->margin['left'], $totalTopMargin + $yoffset, $this->width - $this->margin['right'], $totalTopMargin + $yoffset,  $gridColor);
			}
			$yoffset += $fretsSpacing;
		}

		//if the starting fret isn't 0 add a mention with a 2 pixel margin
		if($this->startingFret != 0)
		{
			$str = sprintf('%dfr.', $this->startingFret);

			if(is_int($this->fontStartingFret))
			{
				$font_height = imagefontheight($this->fontStartingFret);

				imagestring($img, $this->fontStartingFret, $this->width - $this->margin['right'] + 2, $totalTopMargin - ($font_height / 2.0), $str, $symbolColor);
			}
			else
			{
				$box = imagettfbboxextended($this->fontStartingFretSize, 0, $this->fontStartingFret, $str);
				imagettftext($img, $this->fontStartingFretSize, 0,  $this->width - $this->margin['right'] + 2, $totalTopMargin - ($box['height'] / 2.0) + $box['top'], $symbolColor, $this->fontStartingFret, $str);
			}
		}


		//draw chord
		$xoffset = 0;
		for($i=0;$i<$nbStrings;$i++)
		{
			if($this->data[$i] === 'x')
			{
				if($this->showUnstrummedStrings)
				{
					imagecross($img, $this->margin['left'] + $xoffset - $upperSymbolSize/2.0, $this->margin['top'] + $titleMargin - 1, $this->margin['left']+$xoffset+$upperSymbolSize/2.0, $this->margin['top'] + $titleMargin+$upperSymbolSize, $symbolColor);
				}
			}
			else
			{
				$stringPos = intval($this->data[$i]);
				if($stringPos)
				{
					$yoffset = ($fretsSpacing / 2) + $fretsSpacing*($stringPos-1-$this->startingFret);
					//imagefilledellipse($img, $this->margin['left']+$xoffset, $this->margin['top'] + $yoffset, $fretsSpacing*$this->circleSize, $fretsSpacing*$this->circleSize, $gridColor);
					imagesmoothcircle($img, $this->margin['left']+$xoffset, $totalTopMargin + $yoffset, intval(round($fretsSpacing*$this->circleSize/2.0)), array( 'R' => $this->symbolColor[0], 'G' => $this->symbolColor[1], 'B' => $this->symbolColor[2] ));
				}
				else
				{
					if($this->showZeros)
					{
						imageellipse($img, $this->margin['left']+$xoffset, $this->margin['top'] + $upperSymbolSize / 2.0 - 1 + $titleMargin, $upperSymbolSize, $upperSymbolSize, $symbolColor);
					}
				}
			}

			$xoffset += $stringSpacing;
		}

		//draw barre chords
		if(count($this->barre))
		{
			$x1 = 0;
			$x2 = 0;
			$yoffset = 0;

			foreach($this->barre as $fret=>$bar)
			{
				$yoffset = ($fretsSpacing / 2) + $fretsSpacing*($fret-1-$this->startingFret);
				$x1 = ($bar[0]-1) * $stringSpacing;
				$x2 = ($bar[1]-1) * $stringSpacing;

				imagesmoothcircle($img, $this->margin['left']+$x1, $totalTopMargin + $yoffset, intval(round($fretsSpacing*$this->barreSize/2.0)), array( 'R' => $this->symbolColor[0], 'G' => $this->symbolColor[1], 'B' => $this->symbolColor[2] ));
				imagesmoothcircle($img, $this->margin['left']+$x2, $totalTopMargin + $yoffset, intval(round($fretsSpacing*$this->barreSize/2.0)), array( 'R' => $this->symbolColor[0], 'G' => $this->symbolColor[1], 'B' => $this->symbolColor[2] ));
				imagefilledrectangle($img, $this->margin['left']+$x1, $totalTopMargin + $yoffset - intval(round($fretsSpacing*$this->barreSize/2.0)), $this->margin['left']+$x2, $totalTopMargin + $yoffset + intval(round($fretsSpacing*$this->barreSize/2.0)), $symbolColor);
			}
		}
        $fname=str_replace('/','_',$fname);
        $fff=base_path() . '/public/storage/chords/';
        if (!file_exists($fff)){
        	mkdir($fff, 0755, true);
        }
        $fullfname=$fff . $fname . '.png';
		imagepng($img,$fullfname);
		imagedestroy($img);

	}



//The code below is made of uninteresting getters and setters
//Some basic checks are made and the functions try to be as flexible as possible:
//ie you can enter a numeric string for setWidth for instance,
//but if you really feed the setters something it cannot understand, an
//exception will be thrown

	/**
	 * Set image width
	 *
	 * @param int $v
	 */
	function setWidth($v) {$v = intval($v); if($v > 0) {$this->width=$v;} else {throw new Exception('Strictly positive integers only');}}

	/**
	 * Get image width
	 *
	 * @return int
	 */
	function getWidth() {return $this->width;}

	/**
	 * Set image height
	 *
	 * @param int $v
	 */
	function setHeight($v) {$v = intval($v); if($v > 0) {$this->height=$v;} else {throw new Exception('Strictly positive integers only');}}

	/**
	 * Get image width
	 *
	 * @return int
	 */
	function getHeight() {return $this->height;}

	/**
	 * Provide a 4 value array using the CSS like order top, right, bottom, left
	 *
	 * @param array $v
	 */
	function setMargin($v)
	{
		if(is_array($v) && count($v) >= 4) { $this->margin = array('top'=>intval($v[0]),'right'=>intval($v[1]),'bottom'=>intval($v[2]),'left'=>intval($v[3]));  }
		else {throw new Exception('Please provide an array');}
	}

	/**
	 * Get margin
	 *
	 * @return array
	 */
	function getMargin() { return $this->margin;}


	function setMarginTop($v) {$v = intval($v); if($v > 0) {$this->margin['top']=$v;} else {throw new Exception('Strictly positive integers only');}}
	function getMarginTop() {return $this->margin['top'];}
	function setMarginRight($v) {$v = intval($v); if($v > 0) {$this->margin['right']=$v;} else {throw new Exception('Strictly positive integers only');}}
	function getMarginRight() {return $this->margin['right'];}
	function setMarginBottom($v) {$v = intval($v); if($v > 0) {$this->margin['bottom']=$v;} else {throw new Exception('Strictly positive integers only');}}
	function getMarginBottom() {return $this->margin['bottom'];}
	function setMarginLeft($v) {$v = intval($v); if($v > 0) {$this->margin['left']=$v;} else {throw new Exception('Strictly positive integers only');}}
	function getMarginLeft() {return $this->margin['left'];}

	/**
	 * Set background color.
	 *
	 * @param int $r
	 * @param int $g
	 * @param int $b
	 */
	function setBgColor($r,$g,$b){$r=intval($r); $g=intval($g); $b=intval($b); if($r>=0&&$g>=0&&$b>=0){$this->bgColor=array($r,$g,$b);}else{throw new Exception('positive integers only');}}
	/**
	 * Get background color as an ordered array(r,g,b)
	 *
	 * @return array
	 */
	function getBgColor(){return $this->bgColor;}


	/**
	 * Set symbol colors
	 *
	 * @param int $r
	 * @param int $g
	 * @param int $b
	 */
	function setSymbolColor($r,$g,$b){$r=intval($r); $g=intval($g); $b=intval($b); if($r>=0&&$g>=0&&$b>=0){$this->symbolColor=array($r,$g,$b);}else{throw new Exception('positive integers only');}}
	/**
	 * Get symbol color as an ordered array(r,g,b)
	 *
	 * @return array
	 */
	function getSymbolColor(){return $this->symbolColor;}

	/**
	 * Set grid color.
	 *
	 * @param int $r
	 * @param int $g
	 * @param int $b
	 */
	function setGridColor($r,$g,$b){$r=intval($r); $g=intval($g); $b=intval($b); if($r>=0&&$g>=0&&$b>=0){$this->gridColor=array($r,$g,$b);}else{throw new Exception('positive integers only');}}
	/**
	 * Get background color as an ordered array(r,g,b)
	 *
	 * @return array
	 */
	function getGridColor(){return $this->gridColor;}


	/**
	 * Maximum number of frets to display. Default is 5.
	 *
	 * @param int $v
	 */
	function setMaxFrets($v) {$v = intval($v); if($v > 0) {$this->maxFrets=$v;} else {throw new Exception('Strictly positive integers only');}}
	function getMaxFrets(){return $this->maxFrets;}

	/**
	 * The starting fret to display is 0 by default.
	 *
	 * @param bool $v
	 */
	function setStartingFret($v) {$v = intval($v); if($v >= 0) {$this->startingFret=$v;} else {throw new Exception('positive integers only');}}
	function getStartingFret() {return $this->startingFret;}

	/**
	 * Will display a cross on top by default for unstrummed strings
	 *
	 * @param bool $v
	 */
	function setShowUnstrummedStrings($v){$this->showUnstrummedStrings = (bool)$v;}
	function getShowUnstrummedString(){return $this->showUnstrummedStrings;}

	/**
	 * Will display a "o" by default for unfretted strings
	 */
	function setShowZeros($v){$this->showZeros = (bool)$v;}
	function getShowZeros(){return $this->showZeros;}


	/**
	 * Fretted string symbol size, related to the space between frets
	 */
	function setCircleSize($v){if(is_numeric($v)){$this->circleSize = $v;}else{throw new Exception('Floating point numbers only');}}
	function getCircleSize(){return $this->circleSize;}

	/**
	 * Size of the nut, related to the space between frets
	 */
	function setNutSize($v){if(is_numeric($v)){$this->nutSize = $v;}else{throw new Exception('Floating point numbers only');}}
	function getNutSize(){return $this->nutSize;}

	/**
	 * Size of the upper symbols ("x" and "o"), related to the space between frets
	 */
	function setUpperSymbolSize($v){if(is_numeric($v)){$this->upperSymbolSize = $v;}else{throw new Exception('Floating point numbers only');}}
	function getUpperSymbolSize(){return $this->upperSymbolSize;}

	function setBgPicture($v){$this->bgPicture = $v;}
	function getBgPicture(){return $this->bgPicture;}



	/**
	 * Remove all barre chords
	 */
	function clearBarreChords()
	{$this->barre = array();}

	/**
	 * Add a replace a barre chord on fret $fret, from string $fromString
	 * to string $toString
	 *
	 * @param int $fret
	 * @param int $fromString
	 * @param int $toString
	 */
	function setBarreChord($fret, $fromString, $toString)
	{
		$this->barre[$fret] = array($fromString, $toString);
	}

	/**
	 * Remove a previously set barre chord on fret $fret
	 *
	 * @param int $fret
	 */
	function removeBarreChard($fret)
	{
		if(isset($this->barre[$fret]))
			unset($this->barre[$fret]);
	}


	/**
	 * Set font starting fret. It can be built in PHP font (from 1 to 5) or a TTF file
	 * in that case dont forget to set the font size
	 *
	 * @param mixed $v
	 */
	function setFontStartingFret($v)
	{
		if(is_int($v))
		{
			//1 to 5 is the correct range for built in fonts
			if($v >= 1 && $v <= 5)
				$this->fontStartingFret = $v;
			else
				throw new Exception('Built in font must be in 1 to 5 range');
		}
		else if(is_string($v))
		{
			$this->fontStartingFret = $v;
		}
		else
		{
			throw new Exception('Use a TTF file or a number reprensenting a built in font');
		}
	}
	function getFontStartingFret() { return $this->fontStartingFret;}

	function setFontStartingFretSize($v){if(is_numeric($v)){$this->fontStartingFretSize = $v;}else{throw new Exception('Floating point numbers only');}}
	function getFontStartingFretSize(){return $this->fontStartingFretSize;}


	/**
	 * Set font title if there is one. It can be built in PHP font (from 1 to 5) or a TTF file
	 * in that case dont forget to set the font size
	 *
	 * @param mixed $v
	 */
	function setFontTitle($v)
	{
		if(is_int($v))
		{
			//1 to 5 is the correct range for built in fonts
			if($v >= 1 && $v <= 5)
				$this->fontTitle = $v;
			else
				throw new Exception('Built in font must be in 1 to 5 range');
		}
		else if(is_string($v))
		{
			$this->fontTitle = $v;
		}
		else
		{
			throw new Exception('Use a TTF file or a number reprensenting a built in font');
		}
	}
	function getFontTitle() { return $this->fontStartingFret;}

	function setFontTitleSize($v){if(is_numeric($v)){$this->fontTitleSize = $v;}else{throw new Exception('Floating point numbers only');}}
	function getFontTitleSize(){return $this->fontTitleSize;}


	/**
	 * Title displayed on top of the chord. Set to empty string to hide
	 *
	 * @param mixed $v
	 */
	function setTitle($v) {$this->title=$v;}
	function getTitle(){return $this->title;}

}

?>
