pipeline {
    agent {
        docker {
            image 'php:latest'
        }
    }
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
//         stage('Install PHP') {
//             steps {
//                 sh 'sudo apt-get update && sudo apt-get install -y php'
//             }
//         }
        stage('Install Composer') {
            steps {
                sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer'
            }
        }
        stage('PHPUnit') {
            steps {
                script {
                    sh "composer install --prefer-dist --no-progress"
                    sh "/Hive/vendor/bin/phpunit"
                }
            }
        }
    }
}