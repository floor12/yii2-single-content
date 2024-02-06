# floor12/yii2-single-content

## Yii2 Single Content Editor

This is a simple content editor for Yii2. It allows you to create a lot of single content blocks for landing page or
template parts and then edit it using textarea.

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add module to your project:

```
composer require floor12/yii2-single-content
```

Add module to your config file:

```php
'modules' => [
      'single_content' => [
        'class' => 'floor12\single_content\Module',
        'administratorRoleName' => '@',
    ],
],
```

### Usage

Then add a widget to your view file:

```php
    echo SingleContentItemWidget::widget(['id' => 'example-landing-block-001']);
    echo SingleContentItemWidget::widget(['id' => 'one-more-block']);
```

If you are logged in as an administrator, you can click on the block and edit it using a textarea in the modal window.