pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('SonarQube') {
            steps {
                script { scannerHome = tool 'SonarScanner' }
                withSonarQubeEnv('SonarScanner') {
                    sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=ows -Dsonar.sources=Hive -Dsonar.login=${SONAR_LOGIN} -Dsonar.password=${SONAR_PASSWORD}"
                }
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
    }
}