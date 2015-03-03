# fuelphp-change-logfileextension
[FuelPHP]ログファイルの保存先、ログファイル名、ログ・ファイルの拡張子を変更する方法

[EngineYard](http://www.engineyard.co.jp/)では、`/data/{apprication_name}/shared/log`ディレクトリにある`*.log`ファイルを、自動的に30個残してログローテーションしてくれます。これで、DiskFullを防いでくれます。

でも、FuelPHPのアプリケーションログは、デフォルトでは

```
    fuel
      |-app
         |-logs
             |-2015
                 |-03
                   |-01.php
                   |-02.php
                   |-03.php
```

こんな感じで保存されます。これだと、ログローテーションの対象にはならず、アプリをDeployするたびにアプリケーションログは消えてしまいます。


以下を変更して、FuelPHPのアプリケーションログの保存先、拡張子を変更して、EngineYardのログローテーションの対象とします。



## configファイル変更
fuel->app->config->production->config.php（もしくは、fuel->app->config->config.phpなど）に以下を追記。

```
    return array(
        'log_path'      => '/data/{apprication_name}/shared/log/',  // ログファイルの保存先
        'log_extension' => 'log',                                   // ログファイルの拡張子（php,log,txt etc..）
    );
```


## Logクラスを追加
fuel->app->classes　に添付の[log.php](https://github.com/ikolabo/fuelphp-change-logfileextension/blob/master/config.php)をコピーします。


## 追加したLogクラスを読み込む

fuel->app->bootstrap.phpのAutoloader::add_classesを以下のように変更します。

```
Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
//	'Auth' => COREPATH.'packages/myauth/bootstrap.php',
	'Log' => APPPATH.'classes/log.php',  // ←これを追加
));
```



