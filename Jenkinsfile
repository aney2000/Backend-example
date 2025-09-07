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
                // CORECTAT: Folosim %BUILD_ID% pentru Windows
                bat 'docker build -t php-todo-app:%BUILD_ID% .'
            }
        }

        stage('Run & Test') {
            steps {
                // CORECTAT: Folosim %BUILD_ID% pentru Windows
                bat "docker run -d --name test-app-%BUILD_ID% -p 8081:80 php-todo-app:%BUILD_ID%"
                
                bat 'timeout /t 5'

                echo "Verificam daca aplicatia raspunde..."
                // CORECTAT: Folosim %BUILD_ID% pentru Windows
                bat "docker exec test-app-%BUILD_ID% curl --fail http://localhost/"
                echo "Testul a trecut cu succes!"
            }
        }
    }

    post {
        always {
            script {
                echo "Curatenie... oprire si stergere container de test."
                // CORECTAT: Folosim %BUILD_ID% pentru Windows
                bat "docker stop test-app-%BUILD_ID% || echo Container not found"
                bat "docker rm test-app-%BUILD_ID% || echo Container not found"
            }
        }
    }
}
