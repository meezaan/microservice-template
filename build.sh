# composer install
vendor/bin/phpunit
vendor/bin/phpcs --report=checkstyle --report-file=build/logs/checkstyle.xml --standard PSR2 src/
vendor/bin/phpmd src/ html cleancode,codesize,controversial,design,unusedcode --reportfile build/logs/pmd.html
vendor/bin/phpcpd --log-pmd build/logs/pmd-cpd.xml src/
vendor/bin/phploc --count-tests --log-csv --log-html build/logs/phploc.html src/
vendor/bin/apigen generate src/ --destination build/docs/php
apidoc -i routes/ -o docs/api/

