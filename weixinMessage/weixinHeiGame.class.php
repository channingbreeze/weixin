<?php

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';
require_once dirname ( __FILE__ ) . '/../utils/UniqueIdGenerator.class.php';
require_once dirname ( __FILE__ ) . '/../utils/FileUploader.class.php';

class WeixinHeiGame
{
	private $namePlaceholder;
	private $picPlaceholder;
	private $contentPlaceholder;
	private $titlePlaceholder;
	private $datePlaceholder;
	
	private $desArr;
	private $contentPerMessage;
	
	function __construct() {
		$this->namePlaceholder = "[[name]]";
		$this->picPlaceholder = "[[pic]]";
		$this->contentPlaceholder = "[[content]]";
		$this->titlePlaceholder = "[[title]]";
		$this->datePlaceholder = "[[date]]";
		$this->desArr = array();
		$this->desArr[0] = "转发吧！兄弟！";
		$this->desArr[1] = "我知道你高兴得很！";
		$this->desArr[2] = "这不就是你想要的么？";
		$this->desArr[3] = "表谢我，我叫红领巾！";
		$this->contentPerMessage = 3;
		// 设置随机种子
		mt_srand($this->make_seed());
	}
	
	public function responseHei($keyword) {
		
		$name = mb_substr($keyword, 2, mb_strlen($keyword, 'UTF-8') - 2, 'UTF-8');
		if(strlen($name) == 0) {
			$name = "玩命牛";
		}
		
		$dbArr = $this->getDataFromDB();
		
		$message = $dbArr['title'];
		$message = str_replace($this->namePlaceholder, $name, $message);
		
		$desIndex = rand(0, count($this->desArr)-1);
		$des = $this->desArr[$desIndex];
		
		$arr = array();
		$arr['title'] = $message;
		$arr['des'] = $des;
		$arr['pic'] = $dbArr['pic'];
		
		$conArr = $dbArr['content'];
		$replacedContent = "";
		
		for($i=0; $i<count($conArr); $i++) {
			$oneContent = $conArr[$i];
			$oneContent = str_replace($this->namePlaceholder, $name, $oneContent);
			$replacedContent = $replacedContent . $oneContent;
		}
		
		$uniqueIdGenerator = new UniqueIdGenerator();
		$uid = $uniqueIdGenerator->getUniqueId();
		$htmlName = $uid . ".html";
		
		//$host = "http://lixin.tunnel.mobi/weixin/html/";
		$host = "http://7xjv6k.com1.z0.glb.clouddn.com/";
		
		$htmlUrl = $host . $htmlName;
		$arr['url'] = $htmlUrl;
		
		$fileStr = file_get_contents(dirname ( __FILE__ ) . "/../template/template.html");
		$fileStr = str_replace($this->titlePlaceholder, $message, $fileStr);
		$fileStr = str_replace($this->picPlaceholder, $arr['pic'], $fileStr);
		$fileStr = str_replace($this->contentPlaceholder, $replacedContent, $fileStr);
		$fileStr = str_replace($this->datePlaceholder, date("Y-m-d H:i:s"), $fileStr);
		$htmlFilePath = dirname ( __FILE__ ) . "/../html/" . $htmlName;
		file_put_contents($htmlFilePath, $fileStr);
		
		// 上传至七牛
		$fileUploader = new FileUploader();
		$fileUploader->uploadFile($htmlName, $htmlFilePath);
		
		$sqlHelper = new SQLHelper();
		$sql = "insert into wx_message (gmt_create, gmt_modify, hei_name, title_id, pic_id, content_ids, html_url) values (now(), now(), '" . $name . "', " . $dbArr['titleIndex'] . ", " . $dbArr['picIndex'] . ", '" . $dbArr['contentIndexes'] . "', '" . $htmlUrl . "')";
		$sqlHelper->execute_dqm($sql);
		
		//delete html
		unlink($htmlFilePath);
		
		return $arr;
		
	}
	
	private function getDataFromDB() {
		
		$arr = array();
		
		$sqlHelper = new SQLHelper();
		$sql = "select * from wx_range";
		$rangeArr = $sqlHelper->execute_dql_array($sql);
		for($i=0; $i<count($rangeArr); $i++) {
			if($rangeArr[$i]['range_type'] == "title") {
				$titleIndex = rand($rangeArr[$i]['min_index'], $rangeArr[$i]['max_index']);
				$sql = "select * from wx_title where id=" . $titleIndex;
				$titleArr = $sqlHelper->execute_dql_array($sql);
				$arr['title'] = $titleArr[0]['title'];
				$arr['titleIndex'] = $titleIndex;
			} else if($rangeArr[$i]['range_type'] == "pic") {
				$picIndex = rand($rangeArr[$i]['min_index'], $rangeArr[$i]['max_index']);
				$sql = "select * from wx_pic where id=" . $picIndex;
				$picArr = $sqlHelper->execute_dql_array($sql);
				$arr['pic'] = $picArr[0]['url'];
				$arr['picIndex'] = $picIndex;
			} else if($rangeArr[$i]['range_type'] == "content") {
				$contentIndexes = $this->getMultiRand($this->contentPerMessage, $rangeArr[$i]['min_index'], $rangeArr[$i]['max_index']);
				$ids = "";
				for($j=0; $j<count($contentIndexes); $j++) {
					$ids = $ids . $contentIndexes[$j];
					if($j != count($contentIndexes)-1) {
						$ids = $ids . ",";
					}
				}
				$sql = "select * from wx_content where id in (" . $ids . ")";
				$contentArr = $sqlHelper->execute_dql_array($sql);
				$conArr = array();
				for($j=0; $j<count($contentArr); $j++) {
					$conArr[$j] = $contentArr[$j]['content'];
				}
				$arr['content'] = $conArr;
				$arr['contentIndexes'] = $ids;
			}
		}
		return $arr;
	}
	
	// Please ensure (maxIndex - minIndex > count)
	private function getMultiRand($count, $minIndex, $maxIndex) {
		$arr = array();
		while(count($arr) < $count) {
			$res = rand($minIndex, $maxIndex);
			if(!in_array($res, $arr)) {
				$arr[count($arr)] = $res;
			}
		}
		return $arr;
	}
	
	private function make_seed()
	{
		list($usec, $sec) = explode(' ', microtime());
		return (float) $sec + ((float) $usec * 100000);
	}

}

?>