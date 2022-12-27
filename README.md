# [**Tracy**](https://github.com/nette/tracy) [**Request**](https://github.com/guzzle/guzzle) Checker
[![Downloads](https://img.shields.io/packagist/dt/radek-bruha/tracy-request-checker.svg?style=flat-square)](https://packagist.org/packages/radek-bruha/tracy-request-checker)
[![Build Status](https://img.shields.io/github/actions/workflow/status/radek-bruha/tracy-request-checker/.github/workflows/workflow.yaml?style=flat-square)](https://github.com/radek-bruha/tracy-request-checker/actions)
[![Latest Stable Version](https://img.shields.io/github/release/radek-bruha/tracy-request-checker.svg?style=flat-square)](https://github.com/radek-bruha/tracy-request-checker/releases)

**Usage**
```
composer require radek-bruha/tracy-request-checker
```

**Tracy Usage**

```php
Tracy\Debugger::getBar()->addPanel(new \Bruha\Tracy\RequestCheckerPanel());
```

```php
$handlerStack = \GuzzleHttp\HandlerStack::create();
$handlerStack->push(\Bruha\Tracy\RequestLogger::requestLogger());
$client = new \GuzzleHttp\Client(['handler' => $handlerStack]);
```

**Nette Framework Usage**
```yml
tracy:
    bar: [Bruha\Tracy\RequestCheckerPanel()]
```

```yml
services:
    -
        factory: \GuzzleHttp\HandlerStack::create()
        setup:
            - push(\Bruha\Tracy\RequestLogger::requestLogger())
    - \GuzzleHttp\Client([handler: @GuzzleHttp\HandlerStack()])
```

**Example Website Usage**

![Tracy Request Checker](https://i.imgur.com/DPmAibF.png)
