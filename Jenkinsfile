pipeline {
    agent { docker { image 'composer:latest' } }
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
//         stage('SonarQube') {
//             steps {
//                 script { scannerHome = tool 'SonarQubeScanner' }
//                 withSonarQubeEnv('SonarQube') {
//                     sh "${scannerHome}/bin/./sonar-scanner -Dsonar.projectKey=ows"
//                 }
//             }
//         }
        stage('Install Composer') {
            steps {
                sh "composer install --prefer-dist --no-progress"
            }
        }
        stage('PHPUnit') {
            steps {
                script {

                    sh "/Hive/vendor/bin/phpunit"
                }
            }
        }
    }
}