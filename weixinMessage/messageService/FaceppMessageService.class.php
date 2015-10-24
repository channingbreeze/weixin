<?php

require_once dirname ( __FILE__ ) . '/MessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageObject/MessageObject.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/FaceppUtil.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/ConfigUtil.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/UniqueIdGenerator.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/FileUploader.class.php';

function sortFaces($a, $b)
{
	$aValue = $a->position->center->x - $a->position->width / 2;
	$bValue = $b->position->center->x - $b->position->width / 2;
	if($aValue > $bValue) {
		return 1;
	} else if($aValue < $bValue) {
		return -1;
	} else {
		return 0;
	}
}

class FaceppMessageService extends MessageService {
	
	private $contentPlaceholder;
	private $titlePlaceholder;
	private $datePlaceholder;
	private $jsonPlaceholder;
	private $imgUrlPlaceholder;
	
	function __construct() {
		$this->contentPlaceholder = "[[content]]";
		$this->titlePlaceholder = "[[title]]";
		$this->datePlaceholder = "[[date]]";
		$this->jsonPlaceholder = "[[json]]";
		$this->imgUrlPlaceholder = "[[imgUrl]]";
	}
	
	private function handlePicture($postObj, $jsonBody) {
		$jsonArr = json_decode($jsonBody);
		$faces = $jsonArr->face;
		if(count($faces) > 0) {
			$message = new MessageObject();
			$message->Type = "news";
			$message->FromUserName = $postObj->ToUserName;
			$message->ToUserName = $postObj->FromUserName;
			$message->newsArr = $this->getNewsArray($jsonBody, $jsonArr, $faces);
			return $message;
		} else {
			$message = new MessageObject();
			$message->Type = "text";
			$message->FromUserName = $postObj->ToUserName;
			$message->ToUserName = $postObj->FromUserName;
			$message->Content = "没有找到脸";
			return $message;
		}
	}
	
	private function messageGenerator($faces) {
		$faceArr = array();
		$totalCount = 0;
		$maleCount = 0;
		$femaleCount = 0;
		for($i=0; $i<count($faces); $i++) {
			$oneFace = array();
			$ageValue = $faces[$i]->attribute->age->value;
			$ageRange = $faces[$i]->attribute->age->range;
			$genderValue = $faces[$i]->attribute->gender->value;
			$genderConfidence = $faces[$i]->attribute->gender->confidence;
			$glassValue = $faces[$i]->attribute->glass->value;
			$glassConfidence = $faces[$i]->attribute->glass->confidence;
			$pitchAngle = $faces[$i]->attribute->pose->pitch_angle->value;
			$rollAngle = $faces[$i]->attribute->pose->roll_angle->value;
			$yawAngle = $faces[$i]->attribute->pose->yaw_angle->value;
			$raceValue = $faces[$i]->attribute->race->value;
			$raceConfidence = $faces[$i]->attribute->race->confidence;
			$smiling = $faces[$i]->attribute->smiling->value;
		
			$oneFace['ageValue'] = $ageValue;
			$oneFace['ageRange'] = $ageRange;
			$oneFace['genderValue'] = $genderValue;
			$oneFace['genderConfidence'] = $genderConfidence;
			$oneFace['glassValue'] = $glassValue;
			$oneFace['glassConfidence'] = $glassConfidence;
			$oneFace['pitchAngle'] = $pitchAngle;
			$oneFace['rollAngle'] = $rollAngle;
			$oneFace['yawAngle'] = $yawAngle;
			$oneFace['raceValue'] = $raceValue;
			$oneFace['raceConfidence'] = $raceConfidence;
			$oneFace['smiling'] = $smiling;
		
			$totalCount = $totalCount + 1;
			if($genderValue == "Male" && $genderConfidence > 90) {
				$maleCount = $maleCount + 1;
			} else if($genderValue == "Female" && $genderConfidence > 90) {
				$femaleCount = $femaleCount + 1;
			}
		
			$mes = "";
			if($i == 0) {
				if(count($faces) == 1) {
					$mes = $mes . "图中";
				} else {
					$mes = $mes . "左边第" . ($i + 1) . "位";
				}
			} else {
				$mes = $mes . "左边第" . ($i + 1) . "位";
			}
			if($pitchAngle > 5) {
				$mes = $mes . "充满自信的";
			}
			if($smiling > 5) {
				$mes = $mes . "拥有迷人笑容的";
			} else {
				$mes = $mes . "酷酷的";
			}
			if($genderValue == "Male" && $genderConfidence > 90) {
				$mes = $mes . "帅哥";
			} else if($genderValue == "Female" && $genderConfidence > 90) {
				$mes = $mes . "美女";
			} else {
				$mes = $mes . "人";
			}
			$mes = $mes . "年龄为" . $ageValue . "(±" . $ageRange . ")岁";
			if($raceValue != "Asian" && $raceConfidence > 90) {
				$mes = $mes . "，好像还是老外哦！";
			}
			$oneFace['mes'] = $mes;
			$faceArr[$i] = $oneFace;
		}
		
		$totalMes = "";
		if($totalCount == 1) {
			if($maleCount == 1) {
				$totalMes = $totalMes . "发现帅哥1枚";
			} else if($femaleCount == 1) {
				$totalMes = $totalMes . "发现美女1枚";
			} else {
				$totalMes = $totalMes . "发现一个小伙伴";
			}
		} else {
			$totalMes = $totalMes . "发现" . $totalCount . "枚小伙伴";
			if($maleCount == $totalCount) {
				$totalMes = $totalMes . "全部是帅哥";
			} else if($femaleCount == $totalCount) {
				$totalMes = $totalMes . "全部是美女";
			} else {
				$totalMes = $totalMes . "其中";
				if($maleCount != 0) {
					$totalMes = $totalMes . "帅哥" . $maleCount  . "枚 ";
				}
				if($femaleCount != 0) {
					$totalMes = $totalMes . "美女" . $femaleCount . "枚 ";
				}
				if($totalCount - $maleCount - $femaleCount != 0) {
					$totalMes = $totalMes . "还有" . ($totalCount - $maleCount - $femaleCount) . "位小编是不敢猜的~~";
				}
			}
		}
		$faceArr['mes'] = $totalMes;
		return $faceArr;
	}
	
	private function getNewsArray($jsonBody, $jsonArr, $faces) {
		
		$newsArr = array();
		$news = array();

		usort($faces, "sortFaces");
		$jsonArr->face = $faces;
		$jsonBody = json_encode($jsonArr);
		$faceArr = $this->messageGenerator($faces);

		$uniqueIdGenerator = new UniqueIdGenerator();
		$uid = $uniqueIdGenerator->getUniqueId();
		$htmlName = $uid . ".html";
		
		if(ConfigUtil::getInstance()->isInDebugMode()) {
			$host = "http://lixin.tunnel.mobi/weixin/html/";
		} else {
			$host = "http://7xjv6k.com1.z0.glb.clouddn.com/";
		}
		
		$htmlUrl = $host . $htmlName;
		$news['Url'] = $htmlUrl;
		
		$replacedContent = "<p>" . $faceArr['mes'] . "</p>";
		for($i=0; $i<count($faceArr) - 1; $i++) {
			$replacedContent = $replacedContent . "<p>" . $faceArr[$i]['mes'] . "</p>";
		}
		
		$fileUploader = new FileUploader();
		// 图片存本地或上传至七牛
		if( ConfigUtil::getInstance()->isInDebugMode()) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch,CURLOPT_URL, $jsonArr->url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$file_content = curl_exec($ch);
			curl_close($ch);
			$downloaded_file = fopen(dirname ( __FILE__ ) . "/../../html/" . $uid . ".jpg", 'w');
			fwrite($downloaded_file, $file_content);
			fclose($downloaded_file);
			$imgUrl = "http://lixin.tunnel.mobi/weixin/html/" . $uid . ".jpg";
		} else {
			$fileUploader->fetchFile($uid . ".jpg", $jsonArr->url);
			$imgUrl = "http://7xjv6k.com1.z0.glb.clouddn.com/" . $uid . ".jpg";
		}
		
		$fileStr = file_get_contents(dirname ( __FILE__ ) . "/../../template/faceppTemplate.html");
		
		$fileStr = str_replace($this->titlePlaceholder, $faceArr['mes'], $fileStr);
		$fileStr = str_replace($this->jsonPlaceholder, $jsonBody, $fileStr);
		$fileStr = str_replace($this->contentPlaceholder, $replacedContent, $fileStr);
		$fileStr = str_replace($this->datePlaceholder, date("Y-m-d H:i:s"), $fileStr);
		$fileStr = str_replace($this->imgUrlPlaceholder, $imgUrl, $fileStr);
		$htmlFilePath = dirname ( __FILE__ ) . "/../../html/" . $htmlName;
		file_put_contents($htmlFilePath, $fileStr);
		
		// 上传至七牛
		if(! ConfigUtil::getInstance()->isInDebugMode()) {
			$fileUploader->uploadFile($htmlName, $htmlFilePath);
		}
		
		//delete html
		if(! ConfigUtil::getInstance()->isInDebugMode()) {
			unlink($htmlFilePath);
		}
		
		$news['Title'] = $faceArr['mes'];
		$news['Description'] = "没猜准不要打我~~";
		// for test
		$news['PicUrl'] = "http://7xjv6k.com1.z0.glb.clouddn.com/facepp_logo.png";
		
		$newsArr[0] = $news;
		return $newsArr;
	}
	
	/**
	 * $message->Type 必须
	 * text:
	 * $message->Type = "text"
	 * $message->FromUserName
	 * $message->ToUserName
	 * $message->Content
	 * news:
	 * $message->Type = "news"
	 * $message->FromUserName;
	 * $message->ToUserName;
	 * $message->newsArr;
	 *           foreach ($message->newsArr as $news)
	 *           $news['Title']
	 *           $news['Description']
	 *           $news['PicUrl']
	 *           $news['Url']
	 * none:
	 * $message->Type = "none"
	 */
	public function generateMessage($postObj) {
		$faceppUtil = new FaceppUtil();
		$json = $faceppUtil->getFaceppRes($postObj->PicUrl);
		if($json['http_code'] == 200) {
			$message = $this->handlePicture($postObj, $json['body']);
			return $message;
		} else {
			$message = new MessageObject();
			$message->Type = "text";
			$message->FromUserName = $postObj->ToUserName;
			$message->ToUserName = $postObj->FromUserName;
			$message->Content = "请求接口失败！";
			return $message;
		}
		
	}
	
}

?>