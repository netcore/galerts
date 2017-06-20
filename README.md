# Google Alerts manager

### Installation
1. Install package using command
```bash 
    composer require netcore/galerts
```
2. Add service provider to your app.php file
```php
    'providers' => [
        ...
        Netcore\GAlerts\GAlertsServiceProvider::class,
    ]
```

### Usage

At the top of your controller/service put the following
```php
    use Netcore\GAlerts\GAlert;
```

- Fetch all existing alerts
```php
    GAlert::all();
```

- Find alert by data id
```php
    GAlert::findByDataId('28764d5015595ee0:60bb6f517d7861db:com:en:US:L');
```

- Find alert by data id
```php
    GAlert::findByKeyowrd('My alert');
```

- Create an alert
```php
    $alert = new GAlert;
    
    $alert = $alert
        ->keyword('My alert')
        ->deliverToEmail()
        ->frequencyWeekly()
        ->language('lv')
        ->save();
```

- Update an existing alert
```php
    $alert = GAlert::findByKeyowrd('My alert');
   
    $updated = $alert
        ->keyword('My new alert')
        ->deliverToFeed()
        ->update();
```

- Delete an alert
```php
    $alert = GAlert::findByKeyowrd('My alert');
   
    $alert->delete();
```


