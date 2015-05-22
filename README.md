Pinyin
======

[![Build Status](https://travis-ci.org/fayland/php-lingua-unihan-pinyin.svg?branch=master)](https://travis-ci.org/fayland/php-lingua-unihan-pinyin)

Based on Unihan database

```php
use Lingua\Unihan\PinYin;

echo Pinyin::pinyin('带着希望去旅行比到达终点更美好');
// dài zhe xī wàng qù lǔ xíng bǐ dào dá zhōng diǎn gèng měi hǎo
```

## 安装
使用 Composer 安装:
    ```
    composer require fayland/php-lingua-unihan-pinyin:dev-master
    ```
    或者在你的项目 composer.json 加入：
    ```javascript
    {
        "require": {
            "fayland/php-lingua-unihan-pinyin": "dev-master"
        }
    }

### 设置

```php

Pinyin::set('delimiter', '-');//全局
echo Pinyin::pinyin('带着希望去旅行比到达终点更美好');

// dài-zhe-xī-wàng-qù-lǔ-xíng-bǐ-dào-dá-zhōng-diǎn-gèng-měi-hǎo
```

```php
Pinyin::set('tone', false);
echo Pinyin::pinyin('带着希望去旅行，比到达终点更美好');

// dai zhe xi wang qu lu xing bi dao da zhong dian geng mei hao
```

### SEE ALSO

[https://github.com/overtrue/pinyin](https://github.com/overtrue/pinyin)