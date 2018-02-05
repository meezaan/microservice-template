# composer install
vendor/bin/phpunit
vendor/bin/phpcs --report=checkstyle --report-file=build/logs/checkstyle.xml --standard=PSR2 src/
vendor/bin/phpmd src/ html cleancode,codesize,controversial,design,unusedcode --reportfile build/logs/pmd.html
vendor/bin/phpcpd --log-pmd build/logs/pmd-cpd.xml src/
vendor/bin/phploc src/ > build/logs/phploc.html
vendor/bin/phpdox
apidoc -i routes/ -o build/docs/api/
