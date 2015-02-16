# Database Seeding

データベースにデータを植え付ける方法はいくつかあります。

## Simple Seeding

````
    "seeds" => [
        ["sample_table",function(Builder $builder){
            $builder->insert($data);
        }],
    ],
````

seeds エントリの中に配置された配列のオブジェクトは、
単純にlaravelベースのSeederとして動作します。

これは配列の第一キーをテーブル名、第二キーをシード処理用のクロージャとして動作する
非常にシンプルなものです。

## DBUnit-Based Seeding

DBユニットベースのデータセットをDBに植え付ける事も可能です。

````
    "seeds" => [
        new SomeDatasetFactory1($options),
        new SomeDatasetFactory2($options),
        new SomeDatasetFactory3($options),
    ],
````

seeds エントリの中に配置された、`PHPUnit_Extensions_Database_DataSet_IDataSet`実装のオブジェクトは
全てDBユニットベースのデータセットとして扱われます。

Migrateライブラリでは、いくつかの組み込みのDBUnitDabasetファクトリを用意しています。

