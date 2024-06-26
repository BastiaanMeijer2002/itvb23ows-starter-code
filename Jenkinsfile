pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('Install Composer') {
            steps {
                dir("Hive") {
                    sh 'composer install'
                }
            }
        }
        stage('PHPUnit') {
            steps {
                script {
                    sh "Hive/vendor/bin/phpunit --configuration Hive/phpunit.xml --coverage-clover coverage.xml"
                }
            }
        }
        stage('SonarQube scan') {
            steps {
                script { scannerHome = tool 'SonarScanner' }
                withSonarQubeEnv('SonarScanner') {
                    sh "${scannerHome}/bin/sonar-scanner -Dsonar.project.settings=sonar-project.properties"
                }
            }
        }
        stage("Quality Gate") {
            steps {
              timeout(time: 1, unit: 'HOURS') {
                waitForQualityGate abortPipeline: true
              }
            }
        }
    }
}