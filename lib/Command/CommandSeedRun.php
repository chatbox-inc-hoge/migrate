<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Migrate\Command;

use Symfony\Component\Console\Input\InputOption;

class CommandSeedRun extends Base{

    use SchemaLoaderTrait;

    public function configure(){
        $this->setName("seed:run");
        $this->setDescription("drop tables");
        parent::configure();
        $this->schemaLoaderConfigure();
//        $this->addArgument("groups",InputArgument::IS_ARRAY,"group name",[]);
        $this->addOption("dump","d",InputOption::VALUE_NONE,"dump sql");
        $this->addOption("force","f",InputOption::VALUE_NONE,"execute query");
    }

    protected function handle()
    {
        $seeder = $this->getSeeder();

        foreach($this->getSchemas() as $schema){
            foreach($schema->getSeeds() as $seed){
                $seed->runWithSeeder($seeder);
            }
        }
        exit;



        $qb = $builder->getQueryBuilder();
        $query = $qb->insert("blog_tag")
            ->values([
                "blog_id" => 2,
                "name" => "'hogehoge'",
                "created_at" => time(),
                "updated_at" => time(),
            ]);
        var_dump($query->execute());

//        foreach($this->getSchemas() as $schema){
//            $sqls = $builder->dropSchema($schema);
//            foreach($sqls as $sql){
//                if($this->getOption("dump")){
//                    $this->getOutput()->writeln($sql);
//                }elseif($this->getOption("force")){
//                    $builder->runSql($sql);
//                }else{
//                    $this->line("you should set --force or --dump option");
//                    exit(1);
//                }
//            }
//        }
    }
}