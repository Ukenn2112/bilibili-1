<?php
class bilibiliAnime
{
    public $title=array();//标题
    public $image_url=array();//图片链接
    public $total=array();//总集数
    public $progress=array();//我的进度
    public $evaluate=array();//介绍
    public $season_id=array();//ID号，用于番剧跳转
    public $sum;//番剧数目
//观看记录的处理函数
    private function process($content)
    {
        if (stripos($content,"第"))
        {
			$start=stripos($content,"第");
            $end=stripos($content,"话");
            return substr($content,$start+3,$end-$start-3);
        }
		elseif (stripos($content,"OAD"))
        {
			return "已经追完了咯~";
		}
		else
		{
			return "貌似还没有看呢~";
		}
    }
    private function total($content)
    {
        if ($content==null)
        {
			return "还没开始更新呢~";
        }
		else
		{
			return $content;
		}
    }
    private function getpage($uid)
    {
        $url="https://api.bilibili.com/x/space/bangumi/follow/list?type=1&follow_status=0&pn=1&ps=15&vmid=$uid";
        $ch = curl_init(); //初始化curl模块
        curl_setopt($ch, CURLOPT_URL, $url); //登录提交的地址
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);//这个很关键就是把获取到的数据以文件流的方式返回，而不是直接输出
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //发送请求头
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36",
            "Referer: https://www.bilibili.com/",
        ));

        $info=json_decode(curl_exec($ch),true);
        curl_close($ch);//关闭连接
        return $info['data']['total'];
    }
    public function __construct($uid,$cookie)
    {
        $this->sum=$this->getpage($uid);
        for($i=1;$i<=ceil($this->sum/15);$i++)
        {
            $url="https://api.bilibili.com/x/space/bangumi/follow/list?type=1&follow_status=0&pn=$i&ps=15&vmid=$uid";
            $ch = curl_init(); //初始化curl模块
            curl_setopt($ch, CURLOPT_URL, $url); //登录提交的地址
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);//这个很关键就是把获取到的数据以文件流的方式返回，而不是直接输出
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                //发送请求头
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.90 Safari/537.36",
                "Referer: https://www.bilibili.com/",
                "Cookie: $cookie",
            ));
            $info=json_decode(curl_exec($ch),true);
            curl_close($ch);//关闭连接
            foreach ($info['data']['list'] as $data) {
                array_push($this->title, $data['title']);
                array_push($this->image_url, str_replace('http://', '//', $data['cover']));
                array_push($this->total, $this->total($data['new_ep']['title']));
                array_push($this->progress,$this->process($data['progress']));
                array_push($this->evaluate, $data['evaluate']);
                array_push($this->season_id, $data['season_id']);
            }
        }
    }

}
