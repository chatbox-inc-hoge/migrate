<?php
namespace Migrate\Seeder;

class DBUnitSeeder {


    /**
     * @var \PDO
     */
    protected $pdo;

    protected $database;

    /**
     * @var \PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected $dataset;

    /**
     * @var \PHPUnit_Extensions_Database_ITester
     */
    protected $dbTester;

    function __construct(\PDO $pdo,$database,\PHPUnit_Extensions_Database_DataSet_IDataSet $dataset)
    {
        $this->pdo = $pdo;
        $this->database = $database;
        $this->dataset = $dataset;
    }


    /**
     * @return \PHPUnit_Extensions_Database_ITester
     */
    public function resetDBTester(){
        $this->dbTester = new \PHPUnit_Extensions_Database_DefaultTester($this->getConnection());
    }

    public function getConnection(){
//        $connection = new \PDO("mysql:dbname=needs;host=127.0.0.1;charset=utf8","root","");
//        $schema = "needs";
        return new \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($this->pdo, $this->database);
    }

//    public function getDataSet(){
//        return new DBUnitDataset\ArrayDataset(array(
//            'es_blog' => array(
//                array('id' => 1, 'es_id' => 11, 'data' => 'joe', 'created_at' => '2010-04-24 17:15:23','updated_at' => '2010-04-24 17:15:23'),
//                array('id' => 2, 'es_id' => 12,   'data' => "hogehogeo",  'created_at' => '2010-04-26 12:14:20','updated_at' => '2010-04-24 17:15:23'),
//            ),
//        ));
//    }


    public function setUp(){
        $this->resetDBTester();
        $this->dbTester->setSetUpOperation(\PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT());
        $this->dbTester->setDataSet($this->dataset);
        $this->dbTester->onSetUp();
    }



    public function tearDown(){

    }




}