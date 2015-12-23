main:
	composer.phar install

tests:
	vendor/bin/phpunit -c phpunit.xml tests

tests-coverage:
	vendor/bin/phpunit -c phpunit.xml --coverage-html tests-coverage tests

example:
	php examples/example-simple.php

example-comment:
	php examples/example-comment.php
