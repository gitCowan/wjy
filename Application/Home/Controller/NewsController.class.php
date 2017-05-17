<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends CommonController {
	
    public function newslist(){
		$fid=I('get.nid');
		$newscat=M('newsclass')->select();
		if($fid){
			$where['ncategory']=$fid;
		}else{
			$where['ncategory']=$newscat[0]['fid'];
		}
		$nlist=M('newsinfo')->where($where)->order('nid desc')->select();
	    $this->assign('newslist',$nlist);
	    $this->assign('news',$newscat);	
		$this->display();
    }
    public function newsid(){
    	$nid=I('get.nid');
        $newsid=M('newsinfo')->where('nid='.$nid)->find();
        $this->assign('newsid',$newsid);
        $this->display();
    }
}