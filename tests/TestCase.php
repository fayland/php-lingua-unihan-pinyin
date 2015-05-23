<?php


if (gethostname() == 'Faylands-MacBook-Pro.local') {
    include __DIR__ . '/../lib/Lingua/Unihan/PinYin.php';
} else {
    include __DIR__ . '/../vendor/autoload.php';
}

use Lingua\Unihan\PinYin;

class TestCase extends PHPUnit_Framework_TestCase
{
    protected $pinyin;

    public function setUp()
    {
        # code...
    }

    // test delimiter
    public function testGeneral()
    {
        $this->assertEquals('nín hǎo', PinYin::pinyin('您好'));
        $this->assertEquals('dài zhe xī wàng qù lǚ xíng ， bǐ dào dá zhōng diǎn gèng měi hǎo', PinYin::pinyin('带着希望去旅行，比到达终点更美好'));
        $this->assertEquals('cè shì R60', PinYin::pinyin("测试R60"));
    }

    public function testTemporaryDelimiter() {
        $this->assertEquals('nín-hǎo', PinYin::pinyin('您好', array('delimiter' => '-')));
        PinYin::set('delimiter', '*');
        $this->assertEquals('nín*hǎo', PinYin::pinyin('您好'));
        PinYin::set('delimiter', ' ');
        $this->assertEquals('nín hǎo', PinYin::pinyin('您好'));
    }

    public function testResultWithoutTone()
    {
        $this->assertEquals('dai zhe xi wang qu lü xing ， bi dao da zhong dian geng mei hao', PinYin::pinyin('带着希望去旅行，比到达终点更美好', array('tone' => false)));
    }
}