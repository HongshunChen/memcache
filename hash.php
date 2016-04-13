<?php
/**
 * 哈希算法接口
 */
interface hash{
	public function hash($str);
}
/**
 * 分布式算法接口
 */
interface  distribution {
   public function lookup($key);
}
/**
 * 一致性哈希分布式算法实现类
 */
class Consistent implements hash,distribution{
	protected $nodes=array();//服务器节点
	protected $position=array();//虚拟节点位置
	protected $mul=64;//每个服务器节点具有的虚拟节点个数
	/**
	 * 把字符串转换成整型
	 * @param  string $str 键值
	 * @return int   整型键值
	 */
	public function hash($str){
		return sprintf("%u",crc32($str));
	}
	/**
	 * 查询相应键值位置
	 * @param  string $key 键值名
	 * @return string   $node 服务器节点名称
	 */
	public function lookup($key){
		$point=$this->hash($key);
		//$node=current($this->nodes);//第一个节点
        $node=current($this->position);//第一个节点
		foreach($this->position as $k =>$v){
			if($point<=$k){
				$node=$v;
				break;
			}
		}
		return $node;
	}
	/**
	 * 为每个服务器节点添加虚拟节点位置
	 * @param string $node 服务器节点名称
	 */
	public function addNode($node){
		if(isset($this->nodes[$node])){
			return true;
		}
		for($i=0;$i<$this->mul;$i++){
			$this->position[$this->hash($node.'-'.$i)]=$node;
			$this->nodes[$node][]=$this->hash($node.'-'.$i);//存放每个服务器节点对应的虚拟节点位置
		}
		//$this->nodes[$this->hash($node)]=$node;
		
		$this->sortPosi();
		return true;
	}
	/**
	 * 排序服务器节点位置
	 * 
	 */
	protected function sortNode(){
		ksort($this->nodes,SORT_REGULAR);
		
	}
	/**
	 * 排序虚拟节点位置（小到大）
	 * 
	 */
	protected function sortPosi(){
		ksort($this->position,SORT_REGULAR);
	}
	/**
	 * 删除对应的虚拟节点位置
	 * @param  string $name 节点名称
	 * 
	 */
	public function delNode($name){
		if(!isset($this->nodes[$name])){
			return true;
		}
		foreach($this->nodes[$name] as $k=>$v){
			unset($this->position[$v]);
		}
		unset($this->nodes[$name]);
		return true;

	}
	public function printNodes(){
		print_r($this->nodes);
	}
	public function printPosition(){
		print_r($this->position);
	}
	

}

//$con=new Consistent();
//echo $con->hash('b');
/*$con->addNode('a');
$con->addNode('b');
$con->addNode('c');
$con->printPosition();
$con->delNode('a');
$con->printPosition();


echo $con->hash('nam');
echo $con->lookup('nam');*/
/**
 * 取膜分布式算法实现类
 */
class Moder implements hash,distribution{
	protected $nodes=array();
	public $num=0;//服务器节点个数
	/**
	 * 增加服务器节点
	 * @param string $node 节点名称
	 * @return   true 成功
	 */
	public function addNode($node){
		if(in_array($node, $this->nodes)){
			return true;
		}
		$this->nodes[]=$node;
		$this->num++;
		return true;
	}
	/**
	 * 删除服务器节点
	 * @param  string $node 节点名称
	 * @return true 
	 */
	public function delNode($node){
		if(!in_array($node,$this->nodes)){
			return true;
		}
		
		$key=array_search($node, $this->nodes);
		unset($this->nodes[$key]);
		array_merge($this->nodes);
		$this->num--;
		return true;

	}
	/**
	 * 将字符串型键值整型
	 * @param  string $str 键值名称
	 * @return [type]      [description]
	 */
	public function hash($str){
		return sprintf("%u",crc32($str));
	}
	/**
	 * 查找结点
	 * @param  string $key 键值名
	 * @return string      服务器节点名称
	 */
	public function lookup($key){
		$key=$this->hash($key)%$this->num;
		return $this->nodes[$key];

	}
    public function printNodes(){
		print_r($this->nodes);
	}
}
/*$con=new Moder();
//echo $con->hash('b');
$con->addNode('a');
$con->addNode('b');
$con->addNode('c');
//$con->printPosition();
//$con->delNode('a');
//$con->printPosition();


echo $con->hash('nam');
echo $con->lookup('nam');*/