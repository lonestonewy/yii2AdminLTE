Basic Usage
===========

Get
---
```
Yii::$app->config->get('key1');
Yii::$app->config->get('key2', 'default');
Yii::$app->config->get(['key1' => 'value1']);
```

Set
---
```
Yii::$app->config->set('key1', 'value1');
Yii::$app->config->set('key1', ['value1', 'value2']);
Yii::$app->config->set(['key1' => 'value1']);
```

Delete
------
```
Yii::$app->config->delete('key1');
Yii::$app->config->deleteAll(); // delete all config
```
