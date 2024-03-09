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