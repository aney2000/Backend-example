// Jenkinsfile - Varianta corectată pentru Windows

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
                // Folosim 'bat' (Batch) pentru a rula comenzi în Windows
                // Aceasta este echivalentul lui 'sh' pentru Windows
                bat 'docker build -t php-todo-app:${env.BUILD_ID} .'
            }
        }

        stage('Run & Test') {
            steps {
                bat "docker run -d --name test-app-${env.BUILD_ID} -p 8081:80 php-todo-app:${env.BUILD_ID}"
                
                // Pe Windows, `sleep` este `timeout`
                bat 'timeout /t 5'

                echo "Verificam daca aplicatia raspunde..."
                bat "docker exec test-app-${env.BUILD_ID} curl --fail http://localhost/"
                echo "Testul a trecut cu succes!"
            }
        }
    }

    post {
        always {
            script {
                echo "Curatenie... oprire si stergere container de test."
                // Folosim 'bat' și aici
                bat "docker stop test-app-${env.BUILD_ID} || echo Container not found"
                bat "docker rm test-app-${env.BUILD_ID} || echo Container not found"
            }
        }
    }
}
