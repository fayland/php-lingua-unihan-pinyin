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
        $this->assertEquals('nín hǎo', Pinyin::pinyin('您好'));
        $this->assertEquals('dài zhe xī wàng qù lǚ xíng ， bǐ dào dá zhōng diǎn gèng měi hǎo', Pinyin::pinyin('带着希望去旅行，比到达终点更美好'));
    }

    public function testTemporaryDelimiter() {
        $this->assertEquals('nín-hǎo', Pinyin::pinyin('您好', array('delimiter' => '-')));
        Pinyin::set('delimiter', '*');
        $this->assertEquals('nín*hǎo', Pinyin::pinyin('您好'));
        Pinyin::set('delimiter', ' ');
        $this->assertEquals('nín hǎo', Pinyin::pinyin('您好'));
    }

}