<?php
namespace Trade\Controller;
use Think\Controller;
class IndexController extends GlobalController {
	function _initialize()
	{
		parent::_initialize();
	} 

	public function index()
	{
		if($_GET['title']!=""){
			$where.="package_title like '%".($_GET['title'])."%' ";
		}
		//dump($where);
		$count = D("package")->where($where)->count();
		$pagwAllA = new \Think\Page($count, 30);
		$pagwAllA->setConfig('prev',"上頁");
		$pagwAllA->setConfig('next',"下頁");
		$pagwAllA->setConfig('theme',"%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%");
		$pageShowA = $pagwAllA->show();
		$article=D("package")->where($where)->limit($pagwAllA->firstRow,$pagwAllA->listRows)->select();

		$this->assign('article',$article);
		$this->assign('pageShowA',$pageShowA);
		$this->display();
	}
	public function show(){
		$article=D("package")->where("package_id='".$_GET['id']."'")->find();
		$package=D("package_content")->where("package_id='".$_GET['id']."'")->join("sit_content on package_content.sit_id=sit_content.sit_id")->select();
		if(!$article){
			$this->redirect("Index/index");
		}
		$this->assign('package',$package);
		$this->assign('article',$article);
		$this->assign('title',"TouchTravel - ".$article['package_title']);

		$this->display();
	}
	public function amp(){
		$article=D("article")->where("id='".$_GET['id']."'")->find();
		if(!$article){
			$this->redirect("Index/index");
		}
			$article['title']=utf8_decode($article['title']);
			$article['url']=utf8_decode($article['url']);
			$article['content']=utf8_decode($article['content']);
			$article['content']=str_replace("img", "amp-img", $article['content']);
			$article['content']=str_replace("style=", "class=", $article['content']);
			$amp='
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>';
		$this->assign('amp',$amp);
		$this->assign('article',$article);
		$this->assign('title',"Ccard - ".$article['title']);

		$this->display();
	}
}	