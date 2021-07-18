<?php

```php
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;

$iss = new IssueService(new ArrayConfiguration(
          array(
               'jiraHost' => 'https://your-jira.host.com',
               // for basic authorization:
               'jiraUser' => 'jira-username',
               'jiraPassword' => 'jira-password-OR-api-token',
               // to enable session cookie authorization (with basic authorization only)
               'cookieAuthEnabled' => true,
               'cookieFile' => storage_path('jira-cookie.txt'),
               // if you are behind a proxy, add proxy settings
               "proxyServer" => 'your-proxy-server',
               "proxyPort" => 'proxy-port',
               "proxyUser" => 'proxy-username',
               "proxyPassword" => 'proxy-password',
          )
   ));
```