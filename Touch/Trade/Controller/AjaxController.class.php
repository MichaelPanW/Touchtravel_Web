<?php
	namespace Trade\Controller;
	use Think\Controller;
	class AjaxController extends GlobalController {
		function _initialize()
		{
			parent::_initialize();
		} 
		
		public function index(){
			$this->display();
			
		}
		//抓取內容 get class分類名
		public function content()
		{
			//最新查詢區
			$url="https://www.dcard.tw".$_GET['class']."?latest=true";
			$start='"PostEntry_entry_2rsgm" href="';
			$end='"';
			//讀取網站
			$content=file_get_contents($url);
			$num=1;
			//echo $content;
			//逐一讀取
			while(strpos($content, $start,$num)>0 && strpos($content, $end,$num)>0 && $num>0){
				
				$retu=$this->search($content,$start,$end,$num);
				if(preg_match("/[0-9]+/", $retu,$match)){
					$data['id']=$match[0];
					//將文章網址轉碼存進資料庫
					$data['url']=utf8_encode("https://www.dcard.tw".$retu);
					//抓取時間
					$data['time']=time();
					//檢查時間
					$data['uptime']=time();
					//查查看是否以抓取
					$count=D("article")->where("id=".$data['id'])->count();
					if(!$count){
						//新增進資料庫
						echo date("Y-m-d H:i:s")."  ".utf8_decode($data['url'])."<br>";
						D("article")->data($data)->add();
					}
				}
				$num=strpos($content,$start,strpos($content, $start,$num)+strlen($start));
			}
			//搜尋最熱門
			$url="https://www.dcard.tw".$_GET['class'];
			$start='"PostEntry_entry_2rsgm" href="';
			$end='"';
			$content=file_get_contents($url);
			$num=1;
			//echo $content;
			while(strpos($content, $start,$num)>0 && strpos($content, $end,$num)>0 && $num>0){
				
				$retu=$this->search($content,$start,$end,$num);
				if(preg_match("/[0-9]+/", $retu,$match)){
					$data['id']=$match[0];
					$data['url']=utf8_encode("https://www.dcard.tw".$retu);
					$data['time']=time();
					$data['uptime']=time();
					$count=D("article")->where("id=".$data['id'])->count();
					if(!$count){
						echo date("Y-m-d H:i:s")."  ".utf8_decode($data['url'])."<br>";
						D("article")->data($data)->add();
					}
				}
				$num=strpos($content,$start,strpos($content, $start,$num)+strlen($start));
			}
			echo "<p  style='color:red;'>".$_GET['class']."結束</p><br>";
		}
		//抓分類名 僅一次即可 
		public function classif(){
			
			
			$url="https://www.dcard.tw/f";
			$start='<ul class="ForumEntryGroup_list_cdSR2"';
			$end='</ul>';
			$content=file_get_contents($url);
			$num=1;
			
			//echo $content;
			$retu='<ul class="ForumEntryGroup_list_cdSR2"'.$this->search($content,$start,$end)."</ul>";
			echo $retu;
			//dump(strip_tags($retu)); 
			preg_match_all("/\/f\/(\w)+/", $retu,$match);
			preg_match_all("/([\x7f-\xffa-z0-9A-Z]+)<\/a>/",$retu,$amatch);
			foreach ($match[0] as $key => $value) {
				$data[tag]=$value;
				$data[title]=strip_tags("<a>".$amatch[0][$key]);
				dump($data[title]);
				$count=D("classif")->where("tag='".$data[tag]."'")->count();
				if(!$count){
					D("classif")->data($data)->add();
					
					}else{
					D("classif")->data($data)->where("tag='".$value."'")->save();
				}
			}
			
			dump($match);
			dump($amatch);
		}
		//抓文章內容
		public function article(){
			//查找分類
			$article=D("article")->where("status=0")->select();
			foreach ($article as $key => $value) {
				$url=utf8_decode($value['url']);
				$content=file_get_contents($url);
				$start='"title":"';
				$end='"';
				//標題
				$data[title]=$this->search($content,$start,$end);
				
				$data[title]=utf8_encode($data[title]);
				$start='<div class="Post_content_1xpMb"';
				$end='<footer';
				$data[content]='<div class="Post_content_1xpMb"'.$this->search($content,$start,$end);
				//$data[content]=str_replace("'",'"',$data[content]);
				$data[content]=utf8_encode($data[content]);
				$start='"forumName":"';
				$end='"';
				//類別名
				$data[classif]=$this->search($content,$start,$end);
				$data[status]=1;
				//按讚數
			preg_match("/喜歡 [0-9-,]+<\/span>/", $content,$match);
			$number=str_replace("喜歡 ", "", $match[0]);
			$number=str_replace("</span>", "", $number);
			$number=str_replace(",", "", $number);
			$data[alike]=$number;
				@D("article")->where("id=".$value[id])->data($data)->save();
				
			}
			echo  date("Y-m-d H:i:s")."  <p  style='color:red;'>資料庫重整</p><br>";
		}
		//搜尋的方選 內容 開始資料 結束資料 從第幾個字開始
		function search($content,$start,$end,$startkey=0){
			$head=$start;
			$end=$end;
			$url= substr($content,
			strpos($content, $head,$startkey)+strlen($head),
			strpos($content,$end,strpos($content, $head,$startkey)+strlen($head))
			-strpos($content, $head,$startkey)-strlen($head));
			return $url;
		}
		//消失的文章檢查
		function hiddcheck(){
			//刪除未查到及刪除的文章
			D("article")->where("`classif` LIKE '%html%'")->delete();
			//$wh=utf8_encode("公告");
			//D("article")->where("hidd=0 and status=1 and url like '%".$wh."%'")->data("status=0")->save();
			//抓出10筆最後更新的資料
			$article=D("article")->where("hidd=0 and status=1")->limit("10")->order("uptime asc")->select();
			foreach ($article as $key => $value) {
				$url=utf8_decode($value['url']);
				
				$content=file_get_contents($url);
				
				preg_match("/<title data-react-helmet=\"true\">.+<\/title>/",$content,$match);
				$data['uptime']=time();
			preg_match("/喜歡 [0-9-,]+<\/span>/", $content,$match);
			$number=str_replace("喜歡 ", "", $match[0]);
			$number=str_replace("</span>", "", $number);
			$number=str_replace(",", "", $number);
			$data[alike]=$number;
			//如果標題變dcard代表已經不見了
				if($match[0]=='<title data-react-helmet="true">Dcard</title>'){
					$data['hidd']=1;
				}
				
				D("article")->data($data)->where("id=".$value['id'])->save();
				unset($data);
			}
			
		}
	}	//http://together.nuucloud.com/index.php/Ajax/article.html	