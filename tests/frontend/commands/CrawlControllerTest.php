<?php

namespace luya\crawler\tests\frontend\commands;

use luya\crawler\tests\ConsoleCrawlerTestCase;
use luya\crawler\frontend\Module;
use luya\crawler\CrawlIndexInterface;
use luya\crawler\frontend\commands\CrawlController;
use luya\crawler\models\Builderindex;

class CrawlControllerTest extends ConsoleCrawlerTestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testIndexerInterface()
    {
        $module = new Module('frontendcrawler');
        $module->baseUrl = 'http://localhost';
        $module->indexer = [
            MyTestIndexer::class,
        ];

        $ctrl = new CrawlController('crawler', $module);
        $ctrl->verbose = 0;
        $ctrl->interactive = 0;


        try {
            $ctrl->runAction('index');
        } catch (\Exception $e) {
        }

        $this->assertSame('0', Builderindex::find()->asArray()->count());
    }
}


class MyTestIndexer implements CrawlIndexInterface
{
    public static function indexLinks()
    {
        return [
            'http://localhost/path' => 'LUYA Website',
        ];
    }
}
