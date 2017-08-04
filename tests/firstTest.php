<?php
//假如你的PHP项目中并没有安装PHPUnit依赖，就像我这么写吧，不要用use关键字引入，否则在travis-ci运行时会报错
use HtmlParser\ParserDom;
class Test extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        //$this->client = new \GuzzleHttp\Client( [ 'base_uri' => 'http://www.s.cn', 'http_errors' => false,  ]);
        $this->cookieJar = new \GuzzleHttp\Cookie\CookieJar();
        $this->client = new \GuzzleHttp\Client([ 'cookies' => $this->cookieJar]);
        $this->url_user = "http://u.21mmm.com";
    }


    function testLogin(){
        $response = $this->client->post($this->url_user.'/Public/handerLogin',['form_params'=>["username"=>'a',"password"=>'a']]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = $response->getBody();
        $html_dom = new \HtmlParser\ParserDom($body);
        $pSuccess = $html_dom->find('p.success');
        $success = empty($pSuccess) ? false : true;
        $this->assertTrue($success);
    }

    function testRegister(){
        $registerUsername = 't'.time();
        $response = $this->client->post($this->url_user.'/Public/handerRegister',
                            ['form_params'=>["username"=>$registerUsername,"password"=>'a','repassword'=>'a']]);
        $this->assertEquals(200, $response->getStatusCode());



        $body = $response->getBody();
        $html_dom = new \HtmlParser\ParserDom($body);
        $pSuccess = $html_dom->find('p.success');
        $success = empty($pSuccess) ? false : true;
        $this->assertTrue($success);

        $cookieUser_id = $this->cookieJar->getCookieByName('CnMQkuser_id');
        $this->assertNotNull ($cookieUser_id->getValue());
        //$this->assertArrayHasKey('Value',(array)$cookieUser_id);
    }

    public function testAutoPass()
    {
        $this->assertEquals(
            'yubolun',
            'yubolun'
        );
    }
}


