# Custom Page Types Module for ProcessWire CMF

Adds custom page types, following the principles outlined here: https://processwire.com/docs/tutorials/using-custom-page-types-in-processwire/

## Installation
like any other module in ProcessWire

## Sample classes and methods
Are provided in PageClasses.php

## Define your templates and custom page classes
To add your custom page classes to the respective templates automatically, you need to define them in the array `templateClasses` inside CustomPageTypes.module, line 15. They will be processed at module init().
