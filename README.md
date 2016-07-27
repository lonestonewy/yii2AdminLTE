Yii 2 Advanced Project Template with AdminLTE
===============================

基于 Yii 2 Advanced Project Template 开发，后台管理界面整合了AdminLTE主题模板。

* 整合Yii2-rbac扩展并定制了模板，感谢[dektrium](https://gitter.im/dektrium/yii2-rbac)。
* 基于rbac的权限控制体系，菜单、链接等均纳入权限控制，没有权限的不显示。
* 定制了gii生成器，采用以下约定：“is_”开头的字段作为单选按钮组布尔值处理，“image, photo, screenshot”等字段作为图片处理……控制器集成了文件上传，只需取消注释即可使用……更多等待你去发现。
* 定制了assets资源压缩配置，自带了yuicompressor和compiler，运行后./assets命令即可生成合成后的js和css文件，并在prod环境引用。
* 使用 light\yii2-lock-form 包来做提交按钮的自动禁用。
* 完整保留了响应式布局（列表搜索只会在lg下出现）。
* 整合CKEditor和CKFinder，若字段是content、detail则自动引用。
* 最好用的XML/array互转类
* ActiveRecord基类，行锁定方法（lockForUpdate），生成dropdownlist的items的工具方法（getListData和getListOptions，基于类常量的getConstOptions），上传文件便捷方法（uploadFiles和uploadImages）。
* 日期属性行为插件（自动填充created_at和updated_at），数组序列化、JSON转换行为插件。



目录结构
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    components/          contains common components
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
bin/					 contains yuicompressor and compiler jars
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    components/          contains backend components
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains backend widgets
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```
