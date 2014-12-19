# README

cli based php migration tool using Laravel Database Component And Symfony Console.



migrate database <db_name>

migrate database -d <db_name>

migrate tables <group_name>

migrate seed <group_name>


グルーピングの問題

とりあえず構成が複雑になってくるので1ファイル1グループで決める

ライブラリがスキーマを提供するシーンを考える。

SQL吐き出し機能を考える

Command_Baseからのパースの仕方で考えると楽かも
どうやってBaseで生成したConfigにオプションの値を適用していくか…みたいな。

使う側の気持ちになって考える


yaml の問題。ファイル自体にグループ属性は持ちたい。

> Yamlファイル
 - Connectionは任意。継承する必要あり。使用するConnectionを選べるとなおよし(引数でも対応は可能だし結ぶのはどうなのか…?)
 - Seed含む、Schema含む
 - SeedとSchemaは必ずしも同じグルーピングとは限らない?コマンドが分かれてるからOK?

グループ読み込みの遅延ロード、とか。

SQLダンプの機能とかあるといいよね。


## Config周りの設定

connection
  接続設定コンテナに突っ込まれる。
schema
seed
  サブコンフィグ`_default`としてコンテナに突っ込まれる
includes
  未解決サブコンフィグとしてコンテナに突っ込まれる。

