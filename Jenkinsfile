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
                    sh "Hive/vendor/bin/phpunit Hive/tests"
                }
            }
        }
        stage('SonarQube scan') {
            steps {
                script { scannerHome = tool 'SonarScanner' }
                withSonarQubeEnv('SonarScanner') {
                    sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=ows -Dsonar.sources=Hive -Dsonar.login=admin -Dsonar.password=admin"
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