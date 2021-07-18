<?php
require 'vendor/autoload.php';

use JiraRestApi\Project\ProjectService;
use JiraRestApi\JiraException;

try {
    $proj = new ProjectService();

    $p = $proj->get('TM-20410');
	
    var_dump($p);			
} catch (JiraRestApi\JiraException $e) {
	print("Error Occured! " . $e->getMessage());
}
?>