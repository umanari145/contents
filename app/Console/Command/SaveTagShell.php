<?php
App::uses ( 'AppShell', 'Console/Command' );
class SaveTagShell extends AppShell {

	// モデルを読み込む
	public $uses = [
			'Item',
			'Tag'
	];
	public function main() {
		$this->out ( "start_batch" );
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->func1 ();
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->out ( "last_batch" );
	}
	public function func1() {

		//タグリストの取得
		$tagList = $this->Item->find ( 'list', [
				"fields" => [
						'id',
						'genre'
				],
				"conditions" => [
						"delete_flg" => 0
				]
		] );

        $tagList2 = $this->makeTagArr( $tagList );

		$this->Tag->create();
		$this->Tag->saveAll($tagList2);
	}

	/**
	 * タグの配列(重複のぞく)を作成する
	 *
	 * @param unknown $tagList タグのリスト(１つの要素に空白を挟んだタグのリスト)
	 */
	public function makeTagArr( $tagList ){
		$tagList2=[];
		foreach ( $tagList as $tagline){
			$trimedTagArr = array_map("trim", explode(" ", $tagline ));
			//既存のタグになかったら入れる
			foreach ( $trimedTagArr as $tag){
				if( in_array( $tag ,$tagList2) === false ){
					$tagList2[] = $tag;
				}
			}
		}

		$tagList3=[];
		foreach ( $tagList2 as $tag2 ){
			$tagList3[] =['tag' => $tag2];
		}
		return $tagList3;
	}



}