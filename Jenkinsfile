pipeline {
    agent any
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
                dir("Hive") {
                    sh 'composer install'
                }
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