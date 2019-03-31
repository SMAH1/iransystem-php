<?php
//-------------------
// Convert farsi dos text (iran-system) to windows arabic text (code page 1256)
// Programmer : SMAH1
// Github : https://github.com/SMAH1/
// Date : 2013/12/17
// How to use:
//	IranSystem::ConvertToCP1256($data, true);
//	IranSystem::ConvertFromCP1256($data);
//-------------------
require 'struct.php';

class IranSystem
{
	static $C2F1 = null;		//Structure of convertor
	static $cf_0N = array();	//Number character
	static $cf_0S = array();	//Sing character
	static $cf_1 = array();		//First section of ALEFBA
	static $cf_2 = array();		//Second section of ALEFBA
	static $cf_E = array();		//Extended section of ALEFBA (Use for convert CP1256 to IranSystem)
	static $cf_I = array();		//Ignore section of ALEFBA (Use for convert CP1256 to IranSystem)
	
	static function Setup()
	{
		self::$C2F1 = Struct::factory(
			'Main',			//Old dos code
			'Subsi',		//Subsitute code for windows::Arabic
			'LJ',			//Left Jone Old dos code
			'RJ',			//Right Jone Old dos code
			'NJ'			//Need to add 0xA0
		);
		
		self::$cf_0N[] = self::$C2F1->create(128,0x30,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(129,0x31,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(130,0x32,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(131,0x33,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(132,0x34,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(133,0x35,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(134,0x36,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(135,0x37,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(136,0x38,0,0,0);
		self::$cf_0N[] = self::$C2F1->create(137,0x39,0,0,0);
		
		self::$cf_0S[] = self::$C2F1->create(138,0x2C,0,0,0);
		self::$cf_0S[] = self::$C2F1->create(139,0x2D,0,0,0);
		self::$cf_0S[] = self::$C2F1->create(140,0x3F,0,0,0);
		
		self::$cf_1[] = self::$C2F1->create(141,0xC2,0,0,0);
		self::$cf_1[] = self::$C2F1->create(142,0xC6,1,1,0);
		self::$cf_1[] = self::$C2F1->create(143,0xC1,0,0,0);
		self::$cf_1[] = self::$C2F1->create(144,0xC7,0,0,0);
		self::$cf_1[] = self::$C2F1->create(145,0xC7,0,1,0);
		self::$cf_1[] = self::$C2F1->create(146,0xC8,0,1,1);
		self::$cf_1[] = self::$C2F1->create(147,0xC8,1,1,0);
		self::$cf_1[] = self::$C2F1->create(148,0x81,0,1,1);
		self::$cf_1[] = self::$C2F1->create(149,0x81,1,1,0);
		self::$cf_1[] = self::$C2F1->create(150,0xCA,0,1,1);
		self::$cf_1[] = self::$C2F1->create(151,0xCA,1,1,0);
		self::$cf_1[] = self::$C2F1->create(152,0xCB,0,1,1);
		self::$cf_1[] = self::$C2F1->create(153,0xCB,1,1,0);
		self::$cf_1[] = self::$C2F1->create(154,0xCC,0,1,1);
		self::$cf_1[] = self::$C2F1->create(155,0xCC,1,1,0);
		self::$cf_1[] = self::$C2F1->create(156,0x8D,0,1,1);
		self::$cf_1[] = self::$C2F1->create(157,0x8D,1,1,0);
		self::$cf_1[] = self::$C2F1->create(158,0xCD,0,1,1);
		self::$cf_1[] = self::$C2F1->create(159,0xCD,1,1,0);
		self::$cf_1[] = self::$C2F1->create(160,0xCE,0,1,1);
		self::$cf_1[] = self::$C2F1->create(161,0xCE,1,1,0);
		self::$cf_1[] = self::$C2F1->create(162,0xCF,0,1,0);
		self::$cf_1[] = self::$C2F1->create(163,0xD0,0,1,0);
		self::$cf_1[] = self::$C2F1->create(164,0xD1,0,1,0);
		self::$cf_1[] = self::$C2F1->create(165,0xD2,0,1,0);
		self::$cf_1[] = self::$C2F1->create(166,0x8E,0,1,0);
		self::$cf_1[] = self::$C2F1->create(167,0xD3,0,1,1);
		self::$cf_1[] = self::$C2F1->create(168,0xD3,1,1,0);
		self::$cf_1[] = self::$C2F1->create(169,0xD4,0,1,1);
		self::$cf_1[] = self::$C2F1->create(170,0xD4,1,1,0);
		self::$cf_1[] = self::$C2F1->create(171,0xD5,0,1,1);
		self::$cf_1[] = self::$C2F1->create(172,0xD5,1,1,0);
		self::$cf_1[] = self::$C2F1->create(173,0xD6,0,1,1);
		self::$cf_1[] = self::$C2F1->create(174,0xD6,1,1,0);
		self::$cf_1[] = self::$C2F1->create(175,0xD8,1,1,0);
		
		self::$cf_2[] = self::$C2F1->create(224,0xD9,1,1,0);
		self::$cf_2[] = self::$C2F1->create(225,0xDA,0,0,1);
		self::$cf_2[] = self::$C2F1->create(226,0xDA,0,1,1);
		self::$cf_2[] = self::$C2F1->create(227,0xDA,1,1,0);
		self::$cf_2[] = self::$C2F1->create(228,0xDA,1,0,0);
		self::$cf_2[] = self::$C2F1->create(229,0xDB,0,0,1);
		self::$cf_2[] = self::$C2F1->create(230,0xDB,0,1,1);
		self::$cf_2[] = self::$C2F1->create(231,0xDB,1,1,0);
		self::$cf_2[] = self::$C2F1->create(232,0xDB,1,0,0);
		self::$cf_2[] = self::$C2F1->create(233,0xDD,0,1,1);
		self::$cf_2[] = self::$C2F1->create(234,0xDD,1,1,0);
		self::$cf_2[] = self::$C2F1->create(235,0xDE,0,1,1);
		self::$cf_2[] = self::$C2F1->create(236,0xDE,1,1,0);
		self::$cf_2[] = self::$C2F1->create(237,0xDF,0,1,1);
		self::$cf_2[] = self::$C2F1->create(238,0xDF,1,1,0);
		self::$cf_2[] = self::$C2F1->create(239,0x90,0,1,1);
		self::$cf_2[] = self::$C2F1->create(240,0x90,1,1,0);
		self::$cf_2[] = self::$C2F1->create(241,0xE1,0,1,1);
		self::$cf_2[] = self::$C2F1->create(242,0xE1,0,1,0);
		self::$cf_2[] = self::$C2F1->create(243,0xE1,1,1,0);
		self::$cf_2[] = self::$C2F1->create(244,0xE3,0,1,1);
		self::$cf_2[] = self::$C2F1->create(245,0xE3,1,1,0);
		self::$cf_2[] = self::$C2F1->create(246,0xE4,0,1,1);
		self::$cf_2[] = self::$C2F1->create(247,0xE4,1,1,0);
		self::$cf_2[] = self::$C2F1->create(248,0xE6,0,1,0);
		self::$cf_2[] = self::$C2F1->create(249,0xE5,0,1,1);
		self::$cf_2[] = self::$C2F1->create(250,0xE5,1,1,0);
		self::$cf_2[] = self::$C2F1->create(251,0xE5,1,0,0);
		self::$cf_2[] = self::$C2F1->create(252,0xED,0,1,1);
		self::$cf_2[] = self::$C2F1->create(253,0xED,0,0,1);
		self::$cf_2[] = self::$C2F1->create(254,0xED,1,1,0);
		
		self::$cf_E[] = self::$C2F1->create(237,0x98,0,1,1);
		self::$cf_E[] = self::$C2F1->create(238,0x98,1,1,0);
		self::$cf_E[] = self::$C2F1->create(252,0xEC,0,1,1);
		self::$cf_E[] = self::$C2F1->create(253,0xEC,0,0,1);
		self::$cf_E[] = self::$C2F1->create(254,0xEC,1,1,0);
		self::$cf_E[] = self::$C2F1->create(138,0xA1,0,0,0);
		self::$cf_E[] = self::$C2F1->create(140,0xBF,0,0,0);
		self::$cf_E[] = self::$C2F1->create(249,0xC9,0,0,0);
		self::$cf_E[] = self::$C2F1->create(0,0x9D,0,0,0);	//Apply left/right join (But in final will be ignored)
		self::$cf_E[] = self::$C2F1->create(0,0xFE,0,0,0);	//Apply left/right join (But in final will be ignored)
		
		self::$cf_I[] = self::$C2F1->create(1,0x9D,0,0,0);	//Use left/right in last section
		self::$cf_I[] = self::$C2F1->create(0,0xF0,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF1,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF2,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF3,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF4,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF5,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF6,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF7,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF8,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xF9,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xFA,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xFB,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xFC,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xFD,0,0,0);
		self::$cf_I[] = self::$C2F1->create(1,0xFE,0,0,0);
		self::$cf_I[] = self::$C2F1->create(0,0xFF,0,0,0);
	}
	
	//$data : string
	//$r2l : boolean : Usually 'true'
	public static function ConvertToCP1256($data,$r2l)
	{
		if(self::$C2F1 == null)
		{
			self::Setup();
		}
		
		$str = "";
		$nonJoner = " ";//Space
		$addNonJoner = true;
		$isNum = false;
		$slashAscii = ord('/');
		$strNum = '';
		
		$len = strlen($data);

		$begin = $end = $add = 0;
		if($r2l)
		{
			$begin = $len-1;
			$end = 0;
			$add = -1;
		}
		else
		{
			$begin = 0;
			$end = $len-1;
			$add = +1;
		}
		for($i=$begin ;($r2l && $i>=$end) || (!$r2l && $i<=$end);$i = ($i+$add))
		{
			switch(ord($data[$i]))
			{
			case 242://LA Joiner
				$str .= chr(0xE1);
				$str .= chr(0xC7);
				break;
			case 40://LA Joiner
				$str .= chr(0x29);
				break;
			case 41://LA Joiner
				$str .= chr(0x28);
				break;
			case 141:
			case 144:
				if(!$addNonJoner)
				{
					$str .= $nonJoner;
					$addNonJoner = true;
				}
			default:
				{
					$ascii = ord($data[$i]);
					if($isNum && !(($ascii>=128 && $ascii<=137) || ($ascii>=0x30 && $ascii<=0x39)) )
					{
						if($ascii == $slashAscii)
						{
							$strNum .= '/';
							continue;
						}
						else
						{
							$isNum = false;
							$n = strlen($strNum);
							if($strNum[$n-1] == '/')
							{
								$n--;
								$strNum = substr($strNum , 0, $n);
							}
							$m = ($n/2);
							for($j=0;$j<$m;$j++)
							{
								$c = $strNum[$j];
								$strNum[$j] = $strNum[$n-$j-1];
								$strNum[$n-$j-1] = $c;
							}
							$str .= $strNum;

							$addNonJoner = true;
						}
					}
					if($ascii>=128 && $ascii<=137)
					{
						if(!$isNum)
						{
							$isNum = true;
							$strNum = "";
						}
						$strNum .= chr(($ascii-128)+0x30);
					}
					else if($ascii>=0x30 && $ascii<=0x39)
					{
						if(!$isNum)
						{
							$isNum = true;
							$strNum = "";
						}
						$strNum .= $data[$i];
					}
					else if($ascii>=138 && $ascii<=140)
					{
						$str .= chr(self::$cf_0S[$ascii-138]->Subsi);
						$addNonJoner = true;
					}
					else if($ascii>=141 && $ascii<=175)
					{
						if($i!=$begin && self::$cf_1[$ascii-141]->RJ==0)
						{
							$ascii2 = ord($data[$i-$add]);
							if($ascii2>=141 && $ascii2<=175)
							{
								if(self::$cf_1[$ascii2-141]->LJ == 1)
								{
									$str .= $nonJoner;
								}
							}
							else if($ascii2>=224 && $ascii2<=254)
							{
								if(self::$cf_2[$ascii2-224]->LJ == 1)
								{
									$str .= $nonJoner;
								}
							}
						}
						$str .= chr(self::$cf_1[$ascii-141]->Subsi);
						if(self::$cf_1[$ascii-141]->LJ == 0)
						{
							$addNonJoner = true;
						}
						else
							$addNonJoner = false;
					}
					else if($ascii>=224 && $ascii<=254)
					{
						if($i!=$begin && self::$cf_2[$ascii-224]->RJ==0)
						{
							$ascii2 = ord($data[$i+1]);
							if($ascii2>=141 && $ascii2<=175)
							{
								if(self::$cf_1[$ascii2-141]->LJ == 1)
								{
									$str .= $nonJoner;
								}
							}
							else if($ascii2>=224 && $ascii2<=254)
							{
								if(self::$cf_2[$ascii2-224]->LJ == 1)
								{
									$str .= $nonJoner;
								}
							}
						}
						$str .= chr(self::$cf_2[$ascii-224]->Subsi);
						if(self::$cf_2[$ascii-224]->LJ == 0)
						{
							$addNonJoner = true;
						}
						else
							$addNonJoner = false;
					}
					else if($ascii == 0x20)
						$str .= " ";
					else
					{
						$str .= $data[$i];
					}
				}
			}//switch
		}//for
		if($isNum)
		{
			$isNum = false;
			$n = strlen($strNum);
			if($strNum[$n-1] == '/')
			{
				$n--;
				$strNum = substr($strNum , 0, $n);
			}
			$m = ($n/2);
			for($i=0;$i<$m;$i++)
			{
				$c = $strNum[$i];
				$strNum[$i] = $strNum[$n-$i-1];
				$strNum[$n-$i-1] = $c;
			}
			$str .= $strNum;
		}

		$str = rtrim($str);
		$str = str_replace("  "," ",$str);

		return $str;
	}
	
	//$data : string
	public static function ConvertFromCP1256($data)
	{
		if(self::$C2F1 == null)
		{
			self::Setup();
		}
		
		$left_join = array();
		$right_join = array();
		
		$j = strlen($data);
		for($i=0; $i<$j; $i++)
		{
			$byte = ord($data[$i]);
			
			$left = false;
			$right = false;
			foreach(self::$cf_1 as $cf)
			{
				if($cf->Subsi == $byte)
				{
					if($cf->LJ == 1) $left = true;
					if($cf->RJ == 1) $right = true;
					
					if($left && $right)
						break;
				}
			}
			if(!($left && $right))
				foreach(self::$cf_2 as $cf)
				{
					if($cf->Subsi == $byte)
					{
						if($cf->LJ == 1) $left = true;
						if($cf->RJ == 1) $right = true;
						
						if($left && $right)
							break;
					}
				}
			if(!($left && $right))
				foreach(self::$cf_E as $cf)
				{
					if($cf->Subsi == $byte)
					{
						if($cf->LJ == 1) $left = true;
						if($cf->RJ == 1) $right = true;
						
						if($left && $right)
							break;
					}
				}
			
			$left_join[$i] = $left;
			$right_join[$i] = $right;
		}
		
		//Apply Ignore Charater
		for($i=0; $i<$j; $i++)
		{
			$byte = ord($data[$i]);
			
			foreach(self::$cf_I as $cf)
			{
				if($cf->Subsi == $byte)
				{
					if($cf->Main == 0)
					{
						if($i > 0) $right_join[$i] = $right_join[$i-1];
						if($i < $j-1) $left_join[$i] = $left_join[$i+1];
					}
					break;
				}
			}
		}
		
		$converted = array();
		$condid = null;
		$condid_condition = 0;
		$condid_ignore = false;
		for($i=0; $i<$j; $i++)
		{
			$left = false;
			$right = false;
			if($i > 0) $right = $right_join[$i] && $left_join[$i-1];
			if($i < $j-1) $left = $left_join[$i] && $right_join[$i+1];
			
			$condid = null;
			$condid_condition = -1;
			$condid_ignore = false;
			
			$byte = ord($data[$i]);
			
			//echo sprintf('%1$02x ', $byte);
			//echo ($left ? 'LT' : 'LF') . ' ';
			//echo ($right ? 'RT' : 'RF') . ' ';
			
			foreach(self::$cf_1 as $cf)
			{
				if($cf->Subsi == $byte)
				{
					if( ($cf->LJ == 1 && $left == true) && ($cf->RJ == 1 && $right == true) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'A';
					}
					if( ($cf->LJ == 1 && $left == true) && ($cf->RJ == 0 && $right == false) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'B';
					}
					if( ($cf->LJ == 0 && $left == false) && ($cf->RJ == 1 && $right == true) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'C';
					}
					else if ( ($cf->LJ == 1 && $left == true) && $condid_condition < 1)
					{
						$condid = $cf->Main;
						$condid_condition = 1;
						//echo 'D';
					}
					else if ( ($cf->RJ == 1 && $right == true) && $condid_condition < 1)
					{
						$condid = $cf->Main;
						$condid_condition = 1;
						//echo 'E';
					}
					else if ($condid_condition == -1)
					{
						$condid = $cf->Main;
						$condid_condition = 0;
						//echo 'F';
					}
				}
			}
			foreach(self::$cf_2 as $cf)
			{
				if($cf->Subsi == $byte)
				{
					if( ($cf->LJ == 1 && $left == true) && ($cf->RJ == 1 && $right == true) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'G';
					}
					if( ($cf->LJ == 1 && $left == true) && ($cf->RJ == 0 && $right == false) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'H';
					}
					if( ($cf->LJ == 0 && $left == false) && ($cf->RJ == 1 && $right == true) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'I';
					}
					else if ( ($cf->LJ == 1 && $left == true) && $condid_condition < 1)
					{
						$condid = $cf->Main;
						$condid_condition = 1;
						//echo 'J';
					}
					else if ( ($cf->RJ == 1 && $right == true) && $condid_condition < 1)
					{
						$condid = $cf->Main;
						$condid_condition = 1;
						//echo 'K';
					}
					else if ($condid_condition == -1)
					{
						$condid = $cf->Main;
						$condid_condition = 0;
						//echo 'L';
					}
				}
			}
			foreach(self::$cf_E as $cf)
			{
				if($cf->Subsi == $byte)
				{
					if( ($cf->LJ == 1 && $left == true) && ($cf->RJ == 1 && $right == true) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'M';
					}
					if( ($cf->LJ == 1 && $left == true) && ($cf->RJ == 0 && $right == false) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'N';
					}
					if( ($cf->LJ == 0 && $left == false) && ($cf->RJ == 1 && $right == true) && $condid_condition != 2 )
					{
						$condid = $cf->Main;
						$condid_condition = 2;
						//echo 'O';
					}
					else if ( ($cf->LJ == 1 && $left == true) && $condid_condition < 1)
					{
						$condid = $cf->Main;
						$condid_condition = 1;
						//echo 'P';
					}
					else if ( ($cf->RJ == 1 && $right == true) && $condid_condition < 1)
					{
						$condid = $cf->Main;
						$condid_condition = 1;
						//echo 'Q';
					}
					else if ($condid_condition == -1)
					{
						$condid = $cf->Main;
						$condid_condition = 0;
						//echo 'R';
					}
				}
			}
			if(!is_null($condid))
			{
				//echo sprintf(' %1$02x ', $condid);
				//echo $condid_condition;
			}
			//echo PHP_EOL;
			
			foreach(self::$cf_I as $cf)
			{
				if($cf->Subsi == $byte)
				{
					$condid_ignore = true;
				}
			}
			
			if(is_null($condid))
			{
				foreach(self::$cf_0N as $cf)
					if($cf->Subsi == $byte)
					{
						$condid = $cf->Main;
						$condid_condition = 0;
						break;
					}
				foreach(self::$cf_0S as $cf)
					if($cf->Subsi == $byte)
					{
						$condid = $cf->Main;
						$condid_condition = 0;
					}
			}
			
			if(is_null($condid))
				$condid = $byte;
			
			if($condid_ignore == false)
				$converted[] = $condid;
		}
		$j = count($converted);
		
		//Change direction of number
		for($i=0; $i<$j; $i++)
		{
			if($converted[$i] >= 128 && $converted[$i] <= 137)
			{
				for($k=$i+1; $k<$j; $k++)
				{
					if(!($converted[$k] >= 128 && $converted[$k] <= 137))
						break;
				}
				
				$len = $k-$i;
				if($len > 1)
				{
					$len /= 2;
					$k--;
					//echo "SWAP : " . $i . " : " . $k . PHP_EOL;
					for($m=0; $m<$len; $m++)
					{
						$e = $converted[$i+$m];
						$converted[$i+$m] = $converted[$k-$m];
						$converted[$k-$m] = $e;
					}
				}
				
				$i = $k;
			}
		}
		
		$ret = '';
		for($i=count($converted)-1; $i>=0; $i--)
		{
			$ret .= chr($converted[$i]);
		}
		
		return $ret;
	}
}

?>