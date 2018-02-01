#!/usr/bin/env groovy

node('php') {

    stage('Get code from SCM') {
        checkout(
                [$class: 'GitSCM', branches: [[name: '*/master']],
                 doGenerateSubmoduleConfigurations: false,
                 extensions: [],
                 submoduleCfg: [],
                 userRemoteConfigs: [[url: '#your-git-link#']]]
        )
    }

    stage('Composer Install') {
        sh 'composer install'
    }


    stage("PHPUnit") {
        sh 'vendor/bin/phpunit'
    }

    stage("Publish Coverage") {
        publishHTML (target: [
                allowMissing: false,
                alwaysLinkToLastBuild: false,
                keepAll: true,
                reportDir: 'build/coverage',
                reportFiles: 'index.html',
                reportName: "Coverage Report"

        ])
    }

    stage('Checkstyle Report') {
        sh 'vendor/bin/phpcs --report=checkstyle --report-file=build/logs/checkstyle.xml --standard=phpcs.xml --extensions=php,inc --ignore=autoload.php --ignore=vendor/ src || exit 0'
        checkstyle pattern: 'build/logs/checkstyle.xml'
    }

    stage('Mess Detection Report') {
        sh 'vendor/bin/phpmd src xml phpmd.xml --reportfile build/logs/pmd.xml --exclude vendor/ --exclude autoload.php || exit 0'
        pmd canRunOnFailed: true, pattern: 'build/logs/pmd.xml'
    }

    stage('CPD Report') {
        sh 'vendor/bin/phpcpd --log-pmd build/logs/pmd-cpd.xml --exclude vendor src || exit 0' /* should be vendor/bin/phpcpd but... conflicts... */
        dry canRunOnFailed: true, pattern: 'build/logs/pmd-cpd.xml'
    }

    stage('Lines of Code') {
        sh 'vendor/bin/phploc --count-tests --exclude vendor/ --log-csv build/logs/phploc.csv --log-xml build/logs/phploc.xml app'
    }

    stage('Software metrics') {
        sh 'vendor/bin/pdepend --jdepend-xml=build/logs/jdepend.xml --jdepend-chart=build/pdepend/dependencies.svg --overview-pyramid=build/pdepend/overview-pyramid.svg --ignore=vendor app'
    }

    stage('Generate PHP documentation') {
        sh 'vendor/bin/apigen generate src/ --destination build/docs/php'
    }
    
    stage('Generate API documentation') {
        // Requires node js - npm install apidocjs
        sh 'apidoc -i routes/ -o docs/api/'
    }
    stage('Make Production Ready') {
        sh 'composer install --no-dev'
    }
/*
    stage("Publish Crap4J") { // broken at the moment
        step([$class: 'hudson.plugins.crap4j.Crap4JPublisher', reportPattern: 'build/logs/crap4j.xml', healthThreshold: '10'])
    }
*/

}
