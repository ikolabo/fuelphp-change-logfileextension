# fuelphp-change-logfileextension
[FuelPHP]ログファイル名、ログ・ファイルの拡張子を変更する方法


## configファイル変更
fuel->app->config->production->config.php（もしくは、fuel->app->config->config.phpなど）に以下を追記。

```
    return array(
        'log_extension' => 'log',  //ログファイルの拡張子（php,log,txt etc..）
    );
```


## Logクラスを追加
fuel->app->classes　に添付の[log.php](https://github.com/ikolabo/fuelphp-change-logfileextension/blob/master/log.php)をコピーします。


## 追加したLogクラスを読み込む

fuel->app->bootstrap.phpのAutoloader::add_classesを以下のように変更します。

```
Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
//	'Auth' => COREPATH.'packages/myauth/bootstrap.php',
	'Log' => APPPATH.'classes/log.php',  // ←この行を追加
));
```


これで、fuel->app->logs->20150303.log などのログファイルが作成されていることを確認してください。


