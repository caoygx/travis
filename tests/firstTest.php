<?php
//假如你的PHP项目中并没有安装PHPUnit依赖，就像我这么写吧，不要用use关键字引入，否则在travis-ci运行时会报错
class Test extends PHPUnit_Framework_TestCase
{
    public function testAutoPass()
    {
        $this->assertEquals(
            'yubolun',
            'yubolun'
        );
    }
}