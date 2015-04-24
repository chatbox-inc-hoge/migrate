# README

cli based php migration tool using Laravel Database Component And Symfony Console.


## スキーマ管理
 
````
migrate schema:create [--database hoge] [--all] group 
migrate schema:drop [--all] group
````

## シード管理

````
migrate seed
````


## 課題 & 解決

- 取り回しの面倒臭さ。リバースエンジニアリングの必要性
　→ シーディングを完璧にしてとりあえず回避。

## TODO

- 多階層グルーピング
- SQL吐き出し
- larabelとかのscaffoldも…

-　YamlLoader
- JSONはいらない
- 一括実行、シナリオ実行
- 複数設定の同一グループねじ込み

グルーピングの問題

とりあえず構成が複雑になってくるので1ファイル1グループで決める

ライブラリがスキーマを提供するシーンを考える。

SQL吐き出し機能を考える




SQLダンプの機能とかあるといいよね。


## Config周りの設定

connection
  接続設定コンテナに突っ込まれる。
schema
seed
  サブコンフィグ`default`としてコンテナに突っ込まれる
includes
  未解決サブコンフィグとしてコンテナに突っ込まれる。

