#!/bin/sh

rm -fr docs/api/*
/usr/local/php/bin/phpdoc -d . -t docs/api/	\
	--visibility public,protected
		--ignore __autoload.php		\
		--ignore x.php			\
		--ignore tests*.php		\
		--ignore _old/*


