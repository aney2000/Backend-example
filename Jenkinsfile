// Jenkinsfile - Definește pipeline-ul CI/CD

pipeline {
    agent any // Rulează pe orice agent Jenkins disponibil

    stages {
        // Etapa 1: Preluarea codului sursă de pe GitHub
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        // Etapa 2: Construirea imaginii Docker
        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("php-todo-app:${env.BUILD_ID}")
                }
            }
        }

        // Etapa 3: Rulare și Testare Simplă (Smoke Test)
        stage('Run & Test') {
            steps {
                script {
                    // Pornim containerul pe portul 8081 pentru a evita conflictul cu Jenkins
                    sh "docker run -d --name test-app-${env.BUILD_ID} -p 8081:80 php-todo-app:${env.BUILD_ID}"
                    
                    sleep 5 // Așteptăm ca serverul să pornească

                    // Verificăm dacă aplicația răspunde corect
                    echo "Verificam daca aplicatia raspunde..."
                    sh "docker exec test-app-${env.BUILD_ID} curl --fail http://localhost/"
                    echo "Testul a trecut cu succes!"
                }
            }
        }
    }

    // Etapa finală: Curățenie, se execută întotdeauna
    post {
        always {
            script {
                echo "Curatenie... oprire si stergere container de test."
                sh "docker stop test-app-${env.BUILD_ID} || true"
                sh "docker rm test-app-${env.BUILD_ID} || true"
            }
        }
    }
}