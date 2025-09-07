// Jenkinsfile - Varianta FINALĂ pentru Windows

pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                bat 'docker build -t php-todo-app:%BUILD_ID% .'
            }
        }

        stage('Run & Test') {
            steps {
                bat "docker run -d --name test-app-%BUILD_ID% -p 8081:80 php-todo-app:%BUILD_ID%"
                
                // CORECTAT: Folosim un truc cu PING pentru o pauză de 5 secunde. Este mai stabil.
                bat 'ping -n 6 localhost > nul'

                echo "Verificam daca aplicatia raspunde..."
                bat "docker exec test--app-%BUILD_ID% curl --fail http://localhost/"
                echo "Testul a trecut cu succes!"
            }
        }
    }

    post {
        always {
            script {
                echo "Curatenie... oprire si stergere container de test."
                bat "docker stop test-app-%BUILD_ID% || echo Container not found"
                bat "docker rm test-app-%BUILD_ID% || echo Container not found"
            }
        }
    }
}
